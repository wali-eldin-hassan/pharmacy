/*
      Tooltip message 
      this function show the bootstrap tooltip message fastly 
 */
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $("body").on("contextmenu", "img", function(e) {
        return false;
    });
});
/* TEST */
$(function() {
    function deleteE(_selectr, _form, _url) {
        $(document).on('click', _selectr, function(e) {
            e.preventDefault();
            var inputData = $(_form).serialize();
            var dataId = $(this).attr('data-id');
            var parent = $(this).parents('tr');
            bootbox.confirm({
                size: "small",
                message: "Are you sure?",
                callback: function(result) {
                    if (result === true) {
                        $.ajax({
                            url: _url + '/' + dataId,
                            type: 'DELETE',
                            data: {
                                '_token': $('input[name=_token]').val()
                            },
                            success: function(msg) {
                                if (msg.status === 'success') {
                                    parent.hide();
                                }
                            },
                            error: function(data) {
                                if (data.status === 422) {}
                            }
                        });
                    }
                }
            });
        });
    }
    // Delete product
    deleteE('.deleteBtn', '#deleteForm', '/product');
    // Delete category
    deleteE('.deleteBtnCategory', '#deleteFormCategory', '/category');
    // Delete sales
    deleteE('.deleteBtnSale', '#deleteFormSale', '/sales');
    // Delete customers
    deleteE('.deleteCustomersBtn', '#deleteCustomersForm', '/customers');
    // Delete Backup
    deleteE('.deleteBtnBackup', '#deleteForm', '/setting');
    // Delete users
    deleteE('.deleteUsers', '#deleteUsersForm', '/users');
});
/*
      When click to .deleteBtnProvider this function send ajax request and if the response 
      is success the tr tag will hide 
 */
$(function() {
    $(document).on('click', '.deleteBtnProvider', function(e) {
        e.preventDefault();
        var inputData = $('#deleteFormProvider').serialize();
        var dataId = $(this).attr('data-id');
        var parent = $(this).parents('#provideDiv');
        bootbox.confirm({
            size: "small",
            message: "Are you sure?",
            callback: function(result) {
                if (result === true) {
                    $.ajax({
                        url: '/suppliers' + '/' + dataId,
                        type: 'POST',
                        data: inputData,
                        success: function(msg) {
                            if (msg.status === 'success') {
                                parent.hide();
                            }
                        },
                        error: function(data) {
                            if (data.status === 422) {}
                        }
                    });
                }
            }
        });
    });
});
/*
 *  This function show selected dropdown and put the data-type in hidden input value
 *
 */
$(function() {
    function dropdownSP(_selectr, _input) {
        $(_selectr).on('click', function() {
            $(this).parent().parent().parent().find('button').html($(this).html() + '<span class="caret"></span>');
            $(_input).val($(this).attr('data-type'));
        });
    }
    dropdownSP('#color-dropdown > .dropdown-menu a', '#color_input');
    dropdownSP('#language-dropdown > .dropdown-menu a', '#language_input');
    dropdownSP('#currency-dropdown > .dropdown-menu a', '#currency_input');
    $('#barcode-dropdown .dropdown-menu a').on('click', function() {
        $(this).parent().parent().parent().find('button').html($(this).html() + '<span class="caret"></span>');
        $('#barcode').val($(this).text());
    });
});
/*
 *  This function for product icon 
 *
 *  Take name from li->a data-type and put it in input hidden value
 */
$(function() {
    $('#productIcon > .dropdown-menu a').on('click', function() {
        $(this).parent().parent().parent().find('button').html($(this).html() + '<span class="caret"></span>');
        $('#producIconSelect').val($(this).attr('data-type'));
    });
});
/*
 *  When click to #pstyle this will show and hide style of invoice 
 */
$(document).on('click', '#pstyle', function(e) {
    e.preventDefault();
    var pstyle = $(this).attr('data-id');
    if (pstyle === '1') {
        $('#pstyle2,#trint,#trint_colors').hide();
        $('#pstyle1').show();
        $('#inprint').val('1');
    } else if (pstyle === '2') {
        $('#pstyle1,#trint,#trint_colors').hide();
        $('#pstyle2').show();
        $('#inprint').val('2');
    } else if (pstyle === '3') {
        $('#pstyle1,#pstyle2,#trint_colors').hide();
        $('#trint').show();
        $('#inprint').val('3');
    } else if (pstyle === '4') {
        $('#pstyle1,#pstyle2,#trint').hide();
        $('#trint_colors').show();
        $('#inprint').val('4');
    }
});
/*
 * image preview
 *
 */
$(document).on('click', '#close-preview', function() {
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(function() {
        $('.image-preview').popover('show');
    }, function() {
        $('.image-preview').popover('hide');
    });
});
$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type: "button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class", "close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
        content: "There's no image",
        placement: 'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function() {
        $('.image-preview').attr("data-content", "").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function() {
        var img = $('<img/>', {
            id: 'dynamic',
            width: 250
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function(e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });
});
/*
 *  Discount calculator
 */
$(function() {
    $(".input-discount-calc > input").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $("#before,#discount").keyup(function() {
        var $_b = $('#before').val();
        var $_d = $('#discount').val();
        var $_a = $('#after').val();
        var $_s = $('#saver').val();
        if ($_b && $_d) {
            var $_aResult = parseFloat($_b) - (parseFloat($_b) * (parseFloat($_d) / 100));
            var $_sResult = (parseFloat($_b) * (parseFloat($_d) / 100)).toFixed(2);
            $('#after').val($_aResult);
            $('#saver').val($_sResult);
        }
    });
});
/*
 * This function open new window of your medicins search  
 *
 */
$(function() {
    $('#p').click(function() {
        var $_b = $('#getDrugsInformation').val();
        window.open('https://www.drugs.com/search.php?searchterm=' + $_b + '', 'window name', 'window settings');
        return false;
    });
});
/*
 *  This fucntion for note tools when add note and click on submit form its send ajax request and if 
 *  the response is success the note will append in body 
 */
$(function() {
    $('#noteAddForm').submit(function(e) {
        e.preventDefault();
        $_nName = $(this).parent().parent().find('#noteName').val();
        $_nText = $(this).parent().parent().find('#noteText').val();
        $_nColor = $(this).find('.noteBtnColor').text();
        $.ajax({
            url: '/tools',
            type: 'POST',
            data: {
                'noteName': $_nName,
                'noteText': $_nText,
                'noteColor': $_nColor,
                '_token': $('input[name=_token]').val()
            },
            success: function(msg) {
                if (msg.status === 'success') {
                    $('#noteDiv').append('<div class="col-md-3">' + '<div class="panel panel-default">' + '<div class="panel-heading">' + '<div  id="noteColorDropwdown">' + '<div class="dropdown">' + '<button class="btn btn-white btn-xs dropdown-toggle" data-toggle="dropdown">' + $_nColor + '<span class="caret"></span>' + '</button>' + '<ul class="dropdown-menu dropdown-menu-right">' + '<li><a data-type="White"><i class="fa fa-circle" aria-hidden="true" style="color:#fff;"></i> White</a></li>' + ' <li><a data-type="Orange"><i class="fa fa-circle" aria-hidden="true" style="color:#FF5722;"></i> Orange</a></li>' + ' <li><a data-type="Blue"> <i class="fa fa-circle" aria-hidden="true" style="color:#2196F3;"></i> Blue</a></li>' + ' <li><a data-type="Yellow"><i class="fa fa-circle" aria-hidden="true" style="color:#ffc521;"></i> Yellow</a></li>' + '<li><a data-type="Black"><i class="fa fa-circle" aria-hidden="true" style="color:#363636;"></i> Black</a></li>' + ' </ul>' + '</div>' + '<button type="button" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs" id="btnNoteDelete" data-id="' + msg.msg.id + '">' + '<i class="fa fa-times"></i>' + '</button>' + '</div>' + ' </div>' + ' <div class="panel-body ' + $_nColor + '" id="noteContent">' + '<div class="form-group label-floating" style="margin: 0px;">' + ' <p class="noteName">' + $_nName + '</p>' + '<small class="noteDate" >Now</small>' + '</div>' + '<div class="form-group label-floating" style="margin-top: 0px;">' + ' <textarea class="form-control" id="noteText" cols="20"  maxlength="200" name="noteText" rows="5">' + $_nText + '</textarea>' + '</div>' + '<button class="btn btn-white btn-xs" id="editNote" data-id="' + msg.msg.id + '">Edit</button>' + ' </div>' + '</div>');
                }
            },
            error: function(data) {
                if (data.status === 422) {
                    toastr.error('The note text field is required.');
                }
            }
        });
    });
    $(document).on('click', '#noteDiv .dropdown-menu a', function(e) {
        e.preventDefault();
        $a = $(this).attr('data-type')
        $(this).parent().parent().parent().find('button').html($(this).html() + '<span class="caret"></span>');
        $(this).parent().parent().parent().parent().parent().parent().find('#noteContent').removeClass().addClass('panel-body ' + $(this).attr('data-type'));
    });
    /*
     *  This fucntion for note tools when edit to note and click on submit #editNote form its send ajax request and if 
     *  the response is success the note will edited 
     */
    $(document).on('click', '#editNote', function(e) {
        e.preventDefault();
        $_nName = $(this).parent().find('#noteName').val();
        $_nText = $(this).parent().find('#noteText').val();
        $_nColor = $(this).parent().parent().find('.noteBtnColor').text();
        $_nId = $(this).attr('data-id');
        $.ajax({
            url: '/tools/note/' + $_nId,
            type: 'PUT',
            data: {
                'noteName': $_nName,
                'noteText': $_nText,
                'noteColor': $_nColor,
                '_token': $('input[name=_token]').val()
            },
            success: function(msg) {
                if (msg.status === 'success') {
                    toastr.success('Success');
                }
            },
            error: function(data) {
                if (data.status === 422) {
                    toastr.error('The note text field is required.');
                }
            }
        });
    });
    /*
      When click to #btnNoteDelete this function send ajax request and if the response 
      is success the tr tag will hide 
    */
    $(document).on('click', '#btnNoteDelete', function(e) {
        e.preventDefault();
        var inputData = $('#deleteNotesForm').serialize();
        var dataId = $(this).attr('data-id');
        var $this = $(this);
        bootbox.confirm({
            size: "small",
            message: "Are you sure?",
            callback: function(result) {
                if (result === true) {
                    $.ajax({
                        url: '/tools/note/' + dataId,
                        type: 'DELETE',
                        data: {
                            '_token': $('input[name=_token]').val()
                        },
                        success: function(msg) {
                            if (msg.status === 'success') {
                                $this.parent().parent().parent().parent().hide();
                            }
                        },
                        error: function(data) {
                            if (data.status === 422) {}
                        }
                    });
                }
            }
        });
    });
});
// Open sell modal
$('#salesModel').modal();
// This function load spiner page 
$(window).on('load', function() {
    $('#cover').fadeOut(700);
});
// Toggle Button
$(function() {
    $(document).on('change', '#togglePermission', function(e) {
        e.preventDefault();
        if ($(this).val() === '1') {
            $(this).val('2');
        } else {
            $(this).val('1');
        }
    });
})
//Search function for product customer and invoice
$(function() {
    $("#Search").keyup(function() {
        $('#resultSearchBox').empty();
        $('#resultSearchBox').show();
        var _search = $(this).val();
        if (_search === '') {
            $('#resultSearchBox').hide();;
            return false;
        }
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '/search',
            data: {
                '_token': $('input[name=_token]').val(),
                'search': _search
            },
            success: function(data) {
                var $a = '';
                $.each(data, function(i, result) {
                    console.log(result.invoice);
                    if (result.type === 'products') {
                        $a += '<a href="/product/' + result.id + '"><div id="productName">',
                            $a += '<i class="fa fa-medkit fa-3x"></i> ',
                            $a += '<h4>' + result.name + '</h4>',
                            $a += '</div></a>'
                    } else if (result.type === 'customers') {
                        $a += '<a href="/customers/' + result.id + '"><div id="customerName">',
                            $a += '<i class="fa fa-users fa-3x"></i> ',
                            $a += '<h4>' + result.name + '</h4>',
                            $a += '</div></a>'
                    } else if (result.type === 'orders') {
                        $a += '<a href="/sales/' + result.id + '"><div id="invoiceName">',
                            $a += '<i class="fa fa-file-text-o fa-3x"></i> ',
                            $a += '<h4>' + result.name + '</h4>',
                            $a += '</div></a>'
                    }
                });
                $('#resultSearchBox').html($a);
            }
        });
    });
});
// date function  
function dateFormat($date) {
    var now = new Date($date)
    months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    var formattedDate = now.getDate() + "-" + months[now.getMonth()] + "-" + now.getFullYear()
    return formattedDate;
}