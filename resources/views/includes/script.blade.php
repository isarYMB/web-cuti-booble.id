<!-- General JS Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>
<!-- JS Libraies -->
<script src="{{ asset('bundles/echart/echarts.js') }}"></script>
<script src="{{ asset('bundles/chartjs/chart.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/index.js') }}"></script>
<!-- Template JS File -->
<script src="{{ asset('js/scripts.js') }}"></script>

<!-- myscript -->
<!-- Custom JS File -->
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('bundles/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('bundles/cleave-js/dist/addons/cleave-phone.us.js') }}"></script>
<script src="{{ asset('bundles/jquery-pwstrength/jquery.pwstrength.min.js') }}"></script>
<script src="{{ asset('bundles/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('bundles/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('bundles/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('bundles/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>


<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
<script src="{{ asset('bundles/izitoast/js/iziToast.min.js') }}"></script>

<script>
    $('#tolakModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);

        var recipient = button.data('id') // Target data-id
        console.log(recipient); // Here you can see the data-id value from a element
        var modal = $(this)
        modal.find('#userTolak').val(recipient); // set input value
    })
</script>

<script>
    $('#tolakModalAdmin').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);

        var recipient = button.data('id') // Target data-id
        console.log(recipient); // Here you can see the data-id value from a element
        var modal = $(this)
        modal.find('#userTolakAdmin').val(recipient); // set input value
    })
</script>

<script>
    $('#ketTolakAdmin').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);

        var recipient = button.data('id') // Target data-id
        console.log(recipient); // Here you can see the data-id value from a element
        var modal = $(this)
        modal.find('#ketTolakAdminUser').val(recipient); // set input value
    })
</script>

<script>
    $('#tolakModalLeader').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);

        var recipient = button.data('id') // Target data-id
        console.log(recipient); // Here you can see the data-id value from a element
        var modal = $(this)
        modal.find('#tolakModalLeaderUser').val(recipient); // set input value
    })
</script>

<script type="text/javascript">
    // Daterangepicker
    jQuery(function($) {
        var someDate = new Date();
        someDate.setDate(someDate.getDate() + 14); //number  of days to add, e.x. 15 days
        var dateFormated = someDate.toISOString().substr(0, 10);


        var today = new Date(); //Get today's date
        var lastDate = new Date(today.getFullYear() + 1, 11, 31); //To get the 31st Dec of next year

        if (jQuery().daterangepicker) {
            if ($(".datepicker").length) {
                $(".datepicker").daterangepicker({
                    locale: {
                        format: "YYYY-MM-DD"
                    },
                    singleDatePicker: true,
                    minDate: dateFormated,
                    maxDate: lastDate, //set the lastDate as maxDate
                    isInvalidDate: function(date) {
                        var dateRanges = [{
                                'start': moment().startOf('year').format('YYYY-MM-DD'),
                                'end': moment().endtOf('year').format('YYYY-MM-DD')
                            },
                            // { 'start': moment('2022-10-25'), 'end': moment('2022-10-30') },
                        ];
                        return dateRanges.reduce(function(bool, range) {
                            return bool || (date >= range.start && date <= range.end || date
                                .day() == 0);
                        }, false);
                    }
                });
            }
        }
    });
</script>


<script>
    $(document).ready(function() {
        const flashData = $("#flash-data").data('flashdata');
        console.log('flash-data', flashData);
        // if(flashData === "Maaf sisa cuti anda sudah habis"){

        //     iziToast.error({
        //         title: 'Error!',
        //         message: flashData,
        //         position: 'topRight'
        //     });

        // }
        if (flashData) {
            iziToast.success({
                title: 'Success !!',
                message: flashData,
                position: 'topRight'
            });
        }
    });
</script>
