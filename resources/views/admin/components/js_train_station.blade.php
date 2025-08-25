<script>
    $(function () {
        let is_check = ''
        $(document).on('click','.js-open-station', function (e){
            e.preventDefault()
            $('#train-line-station').empty();
            $('#station-modal-select').empty();
            $('#train-lines-modal-select').val($(this).data('line'));
            let seleted_station = $(this).data('station')
            let line_name = $(this).data('linename')
            $('#js-submit-station').data('index', $(this).index('.js-open-station'));
            // let ajax_ins = getStationByTrain();
            // if(ajax_ins !== undefined){
            //     ajax_ins.then(function () {
            //         $('#station-modal-select').val(seleted_station);
            //         $('#train-line-station').html(line_name);
            //     })
            // }
            getTrainLineByStationDefault()
            getStationByTrainDefault()
            is_check = ''
            $('#select-stations').modal('show');
        })
        getStationByTrain()
        $('#train-lines-modal-select').on('change',function () {
            if (is_check === '') {
                is_check = 'train_line'
            }
            if (is_check !== 'station') {
                getStationByTrain()
            }
        })

        $('#station-modal-select').on('change',function () {
            if (is_check === '') {
                is_check = 'station'
            }
            getTrainLineByStation()
            if (is_check !== 'train_line') {
                getTrainLineByStationCd()
            }
        })

        $('#js-submit-station').on('click', function (e){
            e.preventDefault()
            let line_cd = $('#train-lines-modal-select').val();
            let line_name = $("#train-lines-modal-select :selected").text()
            let station_cd = $('#station-modal-select').val()
            let station_name = $("#station-modal-select :selected").text()

            let index = $(this).data('index')
            let selected_station_div = $('.js-select-station-div')[index];

            // fill data
            $(selected_station_div).find('.line-name').text($('#train-line-station').text())
            $(selected_station_div).find('.line-name-input').val(line_name)
            $(selected_station_div).find('.station-name').text(station_name)
            $(selected_station_div).find('.station-name-input').val(station_name)
            $(selected_station_div).find('.station-cd').val(station_cd)
            $(selected_station_div).find('.line-cd').val(line_cd)
        })

        function getTrainLineByStationDefault () {
            return $.ajax({
                type: 'get',
                url: '{{ route('ajax.train_lines.index') }}',
                dataType: 'json',
            }).done((res) => {
                $('#train-lines-modal-select').empty()
                $('#train-lines-modal-select').append(`<option value="" class="js-static">--</option>`)
                $.each(res.line_names, function (index, value) {
                    $('#train-lines-modal-select').append(`<option value="${value.line_cd}">${value.line_name}</option>`)
                })
            }).fail((error) => {
                console.error(error.statusText)
            })
        }

        function getTrainLineByStation () {
            let station_g_cd = $('#station-modal-select').val();
            $('#js-submit-station').addClass('disabled')
            if(station_g_cd){
                return $.ajax({
                    type: 'get',
                    url: '{{ route('ajax.train_lines.index') }}',
                    dataType: 'json',
                    data: {
                        station_g_cd: station_g_cd,
                    },
                }).done((res) => {
                    $('#train-line-station').html('')
                    let line_name = ''
                    $.each(res.line_names, function (index, value) {
                        line_name += `${value.line_name}`
                        line_name += index + 1 == res.line_names.length? '' : '、'
                    })
                    $('#train-line-station').html(`${line_name}`)
                    $('#js-submit-station').removeClass('disabled')
                }).fail((error) => {
                    console.error(error.statusText)
                    $('#js-submit-station').removeClass('disabled')
                })
            } else {
                $('#train-line-station').html('')
            }
        }
        function getTrainLineByStationCd () {
            let station_g_cd = $('#station-modal-select').val()
            $('#js-submit-station').addClass('disabled')
            if(station_g_cd !== null){
                return $.ajax({
                    type: 'get',
                    url: '{{ route('ajax.train_lines.index') }}',
                    dataType: 'json',
                    data: {
                        station_g_cd: station_g_cd,
                    },
                }).done((res) => {
                    $('#train-lines-modal-select').empty()
                    $.each(res.line_names, function (index, value) {
                        $('#train-lines-modal-select').append(`<option value="${value.line_cd}">${value.line_name}</option>`)
                    })
                }).fail((error) => {
                    console.error(error.statusText)
                })
            }
        }

        function getStationByTrain () {
            let current_station = $('#station-modal-select-value').val();
            let line_cd = $('#train-lines-modal-select').val();
            if(line_cd !== null){
                return $.ajax({
                    type: 'get',
                    url: '{{ route('ajax.train_stations.index') }}',
                    dataType: 'json',
                    data: {
                        line_cd: line_cd,
                    },
                }).done((res) => {
                    $('#station-modal-select').empty()
                    $('#train-line-station').html('')
                    $('#station-modal-select').append(`<option value="" class="js-static">--</option>`)
                    $.each(res.stations, function (key, value) {
                        let selectedVal = current_station === key ? 'selected' : '';
                        $('#station-modal-select').append(`<option data-station_g_cd="${key}" value="${key}" ${selectedVal}>${value}</option>`)
                    })
                }).fail((error) => {
                    console.error(error.statusText)
                })
            }
        }

        function getStationByTrainDefault () {
            return $.ajax({
                type: 'get',
                url: '{{ route('ajax.train_stations.index') }}',
                dataType: 'json',
            }).done((res) => {
                $('#station-modal-select').empty()
                $('#station-modal-select').append(`<option value="" class="js-static">--</option>`)
                $.each(res.stations, function (key, value) {
                    $('#station-modal-select').append(`<option data-station_g_cd="${key}" value="${key}">${value}</option>`)
                })
            }).fail((error) => {
                console.error(error.statusText)
            })
        }
    })
</script>
