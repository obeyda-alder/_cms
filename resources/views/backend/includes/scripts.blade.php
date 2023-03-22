<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/js/bootstrap.min.js.map') }}" type="text/javascript"></script>
<script src="{{ asset('js/chart.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/chartist.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/misc.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/off-canvas.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/typeahead.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/chart.js/Chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/chartist/chartist.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/chartist/chartist.min.js.map') }}" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        //
    });

    const lengthMenu = [[5,10, 25, 50, 200, 400, 1000, 2000, -1], [5,10, 25, 50, 200, 400, 1000, 'All']];
    const pagle      = 25;
    const language   = { url: "{!! __('base.lang_data_table') !!}" };
    var options = {
        processing: true,
            serverSide: true,
            lengthMenu: lengthMenu,
            pageLength: pagle,
            language: language,
            rowCallback: function(row, data) {
                if( data["deleted_at"] ){
                    $(row).css('background-color', "rgb(201, 76, 76, 0.1)");
                }
            },
    }
    function dataTableActions(data,type,row,meta){
        var actions = '<span class="d-flex element-icon">';
        row.actions.forEach(icon => {
            if(icon.type == 'icon' && icon.method == 'POST'){
                actions += `<a href="javascript:;" onclick="replicateConfirmation('#delete_${icon.request_type}')" id="${icon.id}" class="${icon.class} mx-1" title="${icon.label}">
                                <i class="${icon.icon}"></i>
                            </a>`;
                actions += `<form id="delete_${icon.request_type}" onsubmit="OnFormSubmit(event);" method="POST" action="${icon.link}" style="display: none;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id" value="${icon.id}">
                            </form>`;
            } else {
                actions += `<a href="${icon.link}" id="${icon.id}" class="${icon.class} mx-1" title="${icon.label}">
                                <i class="${icon.icon}"></i>
                            </a>`;
            }
            actions += '</span>';
        });
        return actions;
    }
    function replicateConfirmation(subm){
       $(subm).submit();
    }
    function OnFormSubmit(ev) {
        ev.preventDefault();
        ev.stopPropagation();

        let form   = $(ev.target),
            data   = new FormData(),
            action = form.attr('action'),
            method = form.attr('method');

            var files = form.find('[type=file]');
            $.each(files, function (key, input) {
                if(input.files[0] != undefined)
                {
                    data.append(input.name, input.files[0]);
                }
            });

        $.each(form.serializeArray(), function (key, input) {
            data.append(input.name, input.value);
        });

        let = response_type = '',response_title = '',response_description = '';

        $.ajax({
            data        : data,
            url         : action,
            type        : method,
            processData : false,
            contentType : false,
            success: function (data) {
                response_type           = data.type;
                response_title          = data.title;
                response_description    = data.description;
                if($('#data-table').length)
                {
                    $('#data-table').DataTable().ajax.reload();
                }
                if(data.redirect_url)
                {
                    console.log(data.redirect_url);
                    window.location = data.redirect_url;
                }
                show_toastr(response_type, response_title, response_description)
            },
            error: function (error) {
                if(!error.responseJSON.success)
                {
                    $('.form-control-feedback').remove();
                        if(typeof error.responseJSON.errors !== 'undefined')
                        {
                            let $data = error.responseJSON.errors;
                            var error_text = '';
                            Object.keys($data).forEach((key) => {
                                error_text = `<div class="form-control-feedback"> ${$data[key][0]}</div>`;
                                $(`input[name=${key}]`).after( error_text );
                            })
                        }
                }
                // $(`.form-control-feedback`).fadeOut(6000);
                response_type           = error.responseJSON.type;
                response_title          = error.responseJSON.title;
                response_description    = error.responseJSON.description;
                show_toastr(response_type, response_title, response_description)
            },
        });
    }
</script>
