<script>
    $(document).ready(function () {
        // getCitiesByAjax()
        $('.js-select-prefecture').change(function () {
            $('.js-select-city option:not(.js-static)').remove()
            $('input[name="city"]').val('')
          getCitiesByAjax()
        })

        $('.js-select-prefecture-billing').change(function () {
            $('input[name="billing_city"]').val('')
        })

        function getCitiesByAjax () {
          const selected_city_code = $('.p-locality').val() !== '' ? $('.p-locality').val() : "{{ old('city_code') }}"
          if($('.js-select-prefecture').val() !== null){
              return $.ajax({
                  type: 'get',
                  url: '{{ route('ajax.cities.index') }}',
                  dataType: 'json',
                  data: {
                      prefecture_id: $('.js-select-prefecture').val(),
                  },
              }).done((res) => {
                  $.each(res.cities, function (index, value) {
                      const selectedVal =
                          ($('.p-locality').val() !== '' ? ($('.p-locality').val() === value.name) : (selected_city_code == value.code)) ? 'selected' : ''
                      $('.js-select-city').append(`<option value="${value.id}" ${selectedVal}>${value.name}</option>`)
                  })
              }).fail((error) => {
                  console.error(error.statusText)
              })
          }
        }
        $('.input-post_code_field').on("keyup", function () {
            const zip_code = $('input[name="postal_code"]').val().replace('-', '')

            // Check zipcode is empty
            if (!zip_code.length) {
                return
            }

          fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zip_code}`).
              then(response => response.json()).
              then(data => {
                if (data?.results) {
                  const data_response = data.results[0];
                  document.querySelector('select[name="prefecture_id"]').value = data_response?.prefcode;
                  const ajax_ins = getCitiesByAjax();
                  ajax_ins.then(function() {
                    let cityOptions = document.querySelectorAll('.js-select-city option');
                    cityOptions.forEach(option => {
                      if (option.textContent === data_response?.address2) {
                        option.selected = true;
                      }
                    });
                    $('input[name="city"]').val(data_response?.address2) // Set city
                    $('input[name="address1"]').val(data_response?.address3) // Set address1
                  });
                }
              }).
              catch(error => console.error('Error:', error));
        })

      // Billing address contracts
      $('.input-post_code_field_billing').on('keyup', function() {
        const zip_code = $('input[name="billing_postal_code"]').val().replace('-', '');

        // Check zipcode is empty
        if (!zip_code.length) {
          return;
        }

        fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${zip_code}`).
            then(response => response.json()).
            then(data => {
              if (data?.results) {
                const data_response = data.results[0];
                $('select[name="billing_prefecture_id"]').val(data_response?.prefcode);
                const ajax_ins = getCitiesByAjax();
                ajax_ins.then(function() {
                  $('input[name="billing_city"]').val(data_response?.address2);
                  $('input[name="billing_address1"]').val(data_response?.address3);
                });
              }
            }).
            catch(error => console.error('Error:', error));
      });
    })
</script>
