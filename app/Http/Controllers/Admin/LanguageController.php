<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use App\Services\ActivityLogService;
use App\Services\DataTableService;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    protected DataTableService $dataTableService;
    protected ActivityLogService $activityLogService;

    public function __construct(DataTableService $dataTableService, ActivityLogService $activityLogService)
    {
        $this->dataTableService = $dataTableService;
        $this->activityLogService = $activityLogService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = ['id', 'code', 'flag', 'label', 'default_yn', 'sortno'];
            $data = Language::select($columns);

            $response = $this->dataTableService->processDataTable($data, $request, $columns);
            // Modify the response to include the edit and destroy URLs for each user
            $response['data'] = $response['data']->map(function ($language) {
                $language->edit_url = route('admin.languages.edit', $language->id);
                $language->destroy_url = route('admin.languages.destroy', $language->id);

                return $language;
            });

            return response()->json($response);
        }

        return view('admin.languages.index');
    }

    public function create()
    {
        $language = new Language();
        return view('admin.languages.create', compact('language'));
    }

    public function store(LanguageRequest $request)
    {
        $language = new Language();
        
        $language->fill($request->all());

        if ($request->has('default_yn') && $request->input('default_yn') == 'on') {
            $language->default_yn = 'y';

            Language::where('default_yn', 'y')->update(['default_yn' => null]);
        }

        $language->save();

        return redirect()->route('admin.languages.index')->with(
            'success',
            __('flash_message.success.create', ['id' => $language->id, 'name' => $language->label])
        );
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Language $language, LanguageRequest $request)
    {
        $language->fill($request->all());

        if ($request->has('default_yn') && $request->input('default_yn') == 'on') {
            $language->default_yn = 'y';

            $language_default = Language::where('default_yn', 'y')->first();

            if ($language_default && $language->id != $language_default->id) {
                $language_default->default_yn = null;
                $language_default->save();
            }
        }

        $language->save();

        return redirect()->back()->with(
            'success',
            __('flash_message.success.update', ['id' => $language->id, 'name' => $language->label])
        );
    }
}
