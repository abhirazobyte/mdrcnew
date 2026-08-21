//select 2 reload
$(".modal-content .select2").select2({
    dropdownParent: $('.modal-body')
});
//input with number validation
$('.numbersOnly').keyup(function () {
    if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
       this.value = this.value.replace(/[^0-9\.]/g, '');
    }
});

$("input.numbers").keypress(function(event) {
	return /\d/.test(String.fromCharCode(event.keyCode));
});

//datepicker
$('.input-datepicker, .input-daterange').datepicker({weekStart: 1, dateFormat: 'dd/mm/yy'}).on('changeDate', function(e){ $(this).datepicker('hide'); });

//for holiday modal
$('.chosen-toggle-holiday-select').each(function(index) {
    $(this).on('click', function(){
         $("#holiday-zone-select > option").prop("selected","selected");// Select All Options
         $('#holiday-zone-select').trigger('change');
    });
});
$('.chosen-toggle-holiday-deselect').each(function(index) {
    $(this).on('click', function(){
         $('#holiday-zone-select').val(null).trigger('change');
    });
});

$('.ckeditor').ckeditor();



function getCity(data)
{
    var state_id = $(data).find('option:selected').val();

    var dataString ='method=getCity&id='+state_id;
    $.ajax({
        dataType: 'html',
        type: "POST",
        url: "scripts/ajax/index.php",
        data: dataString,
        success: function (responseData)
        {
            $('#city_id').html(responseData);
        },
        error: function (responseData) {
            console.log('Ajax request not recieved!');
        }
    });
}


function getArea(data)
{
    var city_id = $(data).find('option:selected').val();

    var dataString ='method=getArea&id='+city_id;
    $.ajax({
        dataType: 'html',
        type: "POST",
        url: "scripts/ajax/index.php",
        data: dataString,
        success: function (responseData)
        {
            $('#area_id').html(responseData);
        },
        error: function (responseData) {
            console.log('Ajax request not recieved!');
        }
    });
}
<!-- End: Admin logout -->