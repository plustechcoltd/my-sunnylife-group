<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Admin\LocationExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationRequest;
use App\Imports\Admin\LocationImport;
use App\Models\Contract;
use App\Models\Location;
use App\Models\LocationAccess;
use App\Models\LocationGroup;
use App\Models\Prefecture;
use App\Models\TrainLine;
use App\Services\ActivityLogService;
use App\Services\AdminMemoService;
use App\Services\DataTableService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
{
    protected DataTableService $dataTableService;
    protected ActivityLogService $activityLogService;
    protected AdminMemoService $adminMemoService;

    public function __construct(DataTableService $dataTableService, ActivityLogService $activityLogService, AdminMemoService $adminMemoService)
    {
        $this->dataTableService = $dataTableService;
        $this->activityLogService = $activityLogService;
        $this->adminMemoService = $adminMemoService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                'id', 'name', 'code', 'location_group_id', 'postal_code', 'prefecture_id', 'city_id', 'address1',
                'address2', 'contract.contract_number', 'locationGroup.name',
            ];
            $data = Location::query();
            if ($request->location_group) {
                $data->where('location_group_id', $request->location_group);
            }

            $response = $this->dataTableService->processDataTable($data, $request, $columns);
            $response['data'] = $response['data']->map(function ($location) {
                $contract = $location['contract'];
                $location->name = '<a class="fw-semibold" href="'.route(
                    "admin.locations.edit",
                    $location->id
                ).'">'.$location->name.'</a>';
                $location['edit_url'] = route('admin.locations.edit', $location['id']);
                $location['destroy_url'] = route('admin.locations.destroy', $location['id']);
                $location['contract_number'] = $contract ? '<a class="fw-semibold" href="'.route(
                    "admin.contracts.edit",
                    $contract['id']
                ).'">'.$contract['contract_number'].'</a>' : '';
                $location['location_group_name'] = $location['locationGroup']['name'] ?? '';

                $icon = '<i class="icon-checkmark-circle text-success"></i>';
                $location['post_input'] = $contract && $contract['post_input_yn'] == 'y' ? $icon : '';
                $location['referral'] = $contract && $contract['referral_yn'] == 'y' ? $icon : '';
                $location['direct'] = $contract && $contract['direct_yn'] == 'y' ? $icon : '';

                return $location;
            });

            return response()->json($response);
        }

        $location_groups = LocationGroup::all();

        return view('admin.locations.index', [
            'location_groups' => $location_groups,
        ]);
    }

    public function create()
    {
        $location_groups = LocationGroup::all();
        $prefectures = Prefecture::all();
        $train_lines = TrainLine::all();
        $cities = [];
        $contracts = [];
        $location = Location::getModel();

        $location->code = Location::withTrashed()->max('code') + 1;
        $location = $this->buildLocationAccess($location);

        return view('admin.locations.create', [
            'location' => $location,
            'location_groups' => $location_groups,
            'prefectures' => $prefectures,
            'train_lines' => $train_lines,
            'cities' => $cities,
            'contracts' => $contracts,
        ]);
    }

    public function store(LocationRequest $request)
    {
        DB::beginTransaction();
        try {
            $employerFamilyNames = $request->input('employer_family_names', []);
            $employerFirstNames = $request->input('employer_first_names', []);
            $employerNames = [];

            foreach ($employerFamilyNames as $index => $familyName) {
                $employerNames[] = [
                    'family_name' => $familyName,
                    'first_name' => $employerFirstNames[$index] ?? '',
                ];
            }
            $location = new Location($request->all());
            $location->employer_names = $employerNames;
            $location->save();

            foreach ($request->location_type as $key => $location_type) {
                $location->locationLocationTypes()->create([
                    'location_type' => $location_type,
                ]);
            }
            $this->updateEmployerLocation($location, $request);
            $this->updateLocationAccess($location, $request);

            $this->activityLogService->save(
                $location->getTable(),
                (string) $location->id,
                __FUNCTION__
            );

            $request->session()->flash(
                'success',
                __('flash_message.success.create', ['id' => $location->id, 'name' => $location->name])
            );
            DB::commit();

            return response()->json([
                'flash_message' => __('flash_message.success.create', ['id' => $location->id, 'name' => $location->name]),
            ])->setStatusCode(Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $request->session()->flash('error', __('flash_message.error.create'));
            return '';
        }
    }

    public function edit(Location $location)
    {
        $location_groups = LocationGroup::all();
        $prefectures = Prefecture::all();
        $train_lines = TrainLine::all();
        $location = $this->buildLocationAccess($location);
        $cities = $location->prefecture->cities()->get();
        $contracts = Contract::all();
        $admin_memos = $this->adminMemoService->getByRecordModel(config('mo.model.location.model_name'), $location->id);

        return view('admin.locations.edit', [
            'location' => $location,
            'location_groups' => $location_groups,
            'prefectures' => $prefectures,
            'train_lines' => $train_lines,
            'contracts' => $contracts,
            'cities' => $cities,
            'admin_memos' => $admin_memos,
        ]);
    }

    public function update(LocationRequest $request, Location $location)
    {
        DB::beginTransaction();
        try {
            $employerFamilyNames = $request->input('employer_family_names', []);
            $employerFirstNames = $request->input('employer_first_names', []);
            $employerNames = [];

            foreach ($employerFamilyNames as $index => $familyName) {
                $employerNames[] = [
                    'family_name' => $familyName,
                    'first_name' => $employerFirstNames[$index] ?? '',
                ];
            }
            $location->update($request->all());
            $location->employer_names = $employerNames;
            $location->save();

            $location->locationLocationTypes()->delete();
            foreach ($request->location_type as $key => $location_type) {
                $location->locationLocationTypes()->create([
                    'location_type' => $location_type,
                ]);
            }
            $this->updateEmployerLocation($location, $request);
            $this->updateLocationAccess($location, $request);

            $this->activityLogService->save(
                $location->getTable(),
                (string) $location->id,
                __FUNCTION__
            );

            $request->session()->flash(
                'success',
                __('flash_message.success.update', ['id' => $location->id, 'name' => $location->name])
            );
            DB::commit();

            return response()->json([
                'success' => __('flash_message.success.update', ['id' => $location->id, 'name' => $location->name]),
            ])->setStatusCode(Response::HTTP_OK);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            $request->session()->flash('error', __('flash_message.error.update'));
            return '';
        }
    }

    /**
     * @return Location
     */
    private function buildLocationAccess(Location $location)
    {
        $location_accesses = $location->locationAccesses;
        $line_cd = [];
        $line_name = [];
        $station_g_cd = [];
        $station_name = [];
        $transportation_type = [];
        $access_text = [];
        $total_minutes = [];
        if ($location_accesses) {
            /** @var LocationAccess $location_access */
            foreach ($location_accesses as $key => $location_access) {
                $stations = $location_access->stations;
                $station = $location_access->station;
                $line_cd[] = $station->trainLine->line_cd;
                $line_name_text = '';
                foreach ($stations as $key => $station) {
                    $line_name_text .= $station->trainLine->line_name;
                    $line_name_text .= $key + 1 == $stations->count() ? '' : '、';
                }
                $line_name[] = $line_name_text;
                $station_g_cd[] = $station->station_g_cd;
                $station_name[] = $station->station_name;
                $transportation_type[] = $location_access->transportation_type;
                $access_text[] = $location_access->access_text;
                $total_minutes[] = $location_access->total_time;
            }
        }

        $location->line_cd = $line_cd;
        $location->station_g_cd = $station_g_cd;
        $location->line_name = $line_name;
        $location->station_name = $station_name;
        $location->transportation_type = $transportation_type;
        $location->total_minutes = $total_minutes;
        $location->access_text = $access_text;

        return $location;
    }

    /**
     * @return void
     */
    private function updateEmployerLocation(Location $location, LocationRequest $request)
    {
        $location->employerLocations()->delete();

        if ($request->hasAny(['employer_id'])) {
            $employer_location = [];
            foreach ($request->employer_id as $key => $employer_id) {
                $employer_location[] = ['employer_id' => $employer_id];
            }
            $location->employerLocations()->createMany($employer_location);
        }
    }

    /**
     * @return void
     */
    private function updateLocationAccess(Location $location, LocationRequest $request)
    {
        $location->locationAccesses()->delete();

        if ($request->hasAny(['station_g_cd'])) {
            $station_g_cd_array = $request->get('station_g_cd');
            $total_time_array = $request->get('total_minutes');
            $access_text_array = $request->get('access_text');
            $transportation_type_array = $request->get('transportation_type');
            $number_of_location_accesses = count($station_g_cd_array);
            $new_location_accesses = [];
            $now = Carbon::now();
            for ($i = 0; $i < $number_of_location_accesses; ++$i) {
                if (isset($station_g_cd_array[$i]) && isset($transportation_type_array[$i]) && isset($total_time_array[$i])) {
                    $new_location_accesses[] = [
                        'location_id' => $location->id,
                        'station_g_cd' => $station_g_cd_array[$i],
                        'transportation_type' => $transportation_type_array[$i],
                        'total_time' => $total_time_array[$i],
                        'access_text' => $access_text_array[$i] ?? '',
                        'sortno' => $i + 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            LocationAccess::insert($new_location_accesses);
        }
    }

    public function destroy(Location $location)
    {
        DB::beginTransaction();
        try {
            if ($location->contract()->count()) {
                return redirect()->back()->with(
                    'error',
                    'この医療機関は'.$location->contract()->count().'件の契約状況に紐づく為、削除出来ません。'
                );
            }

            if ($location->fulltimePosts()->count()) {
                return redirect()->back()->with(
                    'error',
                    'この医療機関は'.$location->fulltimePosts()->count().'件の常勤求人に紐づく為、削除出来ません。'
                );
            }

            if ($location->parttimePosts()->count()) {
                return redirect()->back()->with(
                    'error',
                    'この医療機関は'.$location->parttimePosts()->count().'件の非常勤求人に紐づく為、削除出来ません。'
                );
            }

            if ($location->employerLocations()->count()) {
                return redirect()->back()->with(
                    'error',
                    'この医療機関は'.$location->employerLocations()->count().'件の採用担当者に紐づく為、削除出来ません。'
                );
            }

            $location->fulltimePosts()->delete();
            $location->parttimePosts()->delete();
            $location->locationLocationTypes()->delete();
            $location->employerLocations()->delete();
            $location->locationAccesses()->delete();
            $location->delete();

            $this->activityLogService->save(
                $location->getTable(),
                (string) $location->id,
                __FUNCTION__
            );

            DB::commit();

            return back()->with(
                'success',
                __('flash_message.success.delete', ['id' => $location->id, 'name' => $location->name])
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return back()->with('error', __('flash_message.error.delete'));
        }
    }

    public function exportCsv()
    {
        ini_set('memory_limit', -1); // メモリ無制限
        ini_set('max_execution_time', 0); // タイムアウトしない
        ini_set('max_input_time', 0); // パース時間を設定しない

        $export = new LocationExport();

        return Excel::download(
            $export,
            '医療機関一覧エクスポート.csv',
            \Maatwebsite\Excel\Excel::CSV,
            ['Content-Type' => 'text/csv']
        );
    }

    public function importCsv()
    {
        return view('admin.locations.csv_import');
    }

    public function uploadCsv(LocationRequest $request)
    {
        $file = $request->file('import_file');
        DB::beginTransaction();
        try {
            $import = new LocationImport($file);
            $result = Excel::import($import, $file);
            $error_message = $import->getErrorMessage();
            if (null == $error_message) {
                DB::commit();

                $this->activityLogService->save(
                    'locations',
                    '9999',
                    'upload_csv'
                );

                return redirect()->back()->with([
                    'success_csv_message' => "インポートが成功しました。\n".$import->getSuccessMessage(),
                    'warning_csv_message' => $import->getWarningMessage(),
                ]);
            } else {
                DB::rollBack();
                Log::error($error_message);

                return redirect()->back()->with('error_csv_message', "インポートが失敗しました。\n".$error_message);
            }
        } catch (\Exception $e) {
            Log::alert($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', "インポートが失敗しました。");
        }
    }

}
