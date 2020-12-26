var showErrorMsg = function(form, type, msg) {
    var alert = $('<div class="m-alert m-alert--outline alert alert-' + type + ' alert-dismissible" role="alert">\
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>\
        <span></span>\
    </div>');

    form.find('.alert').remove();
    alert.prependTo(form);
    alert.animateClass('fadeIn animated');
    alert.find('span').html(msg);
    form.html();
}

var alertError = function(error, type=1){
    alert('Maaf, terjadi kesalahan. (Error: ' + error + ')');
}

var resendToken = function(res){
    if(res.jwt_token){
        localStorage.setItem("jwt_token", res.jwt_token);
        if(confirm('Token Reseted, please reload!')){
            window.location.reload();  
        }
    }
}

var apiRespone = function(res, callback = null, callthen = null){
    if(res.api_status == 1){
        if(callthen){
            swal({
                title: 'Berhasil!',
                text: res.api_message,
                icon:  'success',
            }).then(()=>{
                callthen(res);
            });
        }else{
            swal({
                title: 'Berhasil!',
                text: res.api_message,
                icon:  'success',
            }); 
        }
    }else if(res.api_status == 0){
        swal({
            title: 'Gagal!',
            text: res.api_message,
            icon:  'error',
        });
        if(res.jwt_token){
            localStorage.setItem("pelops_token", res.jwt_token);
            if(confirm('Token Reseted, please reload!')){
                window.location.reload();  
            }
        }
    }else if(res.api_status == 8){
        swal({
            title: "Apakah anda yakin?",
            text: res.api_message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                callthen(res);
            }
        });
    }
    if(callback){
        callback(res);
    }
}

var apiLoading = function(isLoading, btn = null){
    if(isLoading){
        swal({
            title              : 'Wait',
            buttons            : false,
            className          : 'sweetalert-xs',
            closeOnClickOutside: false,
            closeOnEsc         : false,
        });
    }else{
        swal.close();
    }
    if(btn){
        btn.attr("disabled", isLoading);
    }
}

var getOption = function(tag, url, data, callback = null, defaultvalue = null, geterror = null){
    tag.html("<option value=''>Loading....</option>");
    $.ajax({
        type : 'get',
        url  : url,
        data : data,
        dataType : 'json'
    }).done(function(res) {
        if(res.api_status == 1){
            var option ='';
            res.data.forEach(element => {
                option += "<option value=\"" + element.value + "\" >" + element.name + "</option>";
            });
            tag.html(option);
            if(defaultvalue)
            tag.val(defaultvalue)
            
            if(callback)
            callback();
        }else{
            if(geterror)
            geterror();

            tag.html("<option value=''> ! Error ! </option>");
        }
    }).fail(function(error){
        if(geterror)
        geterror();
        // alert('error');
        tag.html("<option value=''> ! Error ! </option>");
    });
}

function formatMoney(number, decPlaces, decSep, thouSep) {
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSep = typeof decSep === "undefined" ? "." : decSep;
    thouSep = typeof thouSep === "undefined" ? "," : thouSep;
    var sign = number < 0 ? "-" : "";
    var i = String(parseInt(number = Math.abs(Number(number) || 0).toFixed(decPlaces)));
    var j = (j = i.length) > 3 ? j % 3 : 0;

    return sign +
        (j ? i.substr(0, j) + thouSep : "") +
        i.substr(j).replace(/(\decSep{3})(?=\decSep)/g, "$1" + thouSep) +
        (decPlaces ? decSep + Math.abs(number - i).toFixed(decPlaces).slice(2) : "");
}

function formatRupiah(num) {
    // console.log(num);
    num = parseFloat(num);
    var p = num.toFixed(2).split(".");
    return "Rp. " + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
        return  num=="-" ? acc : num + (i && !(i % 3) ? "," : "") + acc;
    }, "") + "." + p[1];
}


function round(num, decimalPlaces = 0) {
    var p = Math.pow(10, decimalPlaces);
    var m = (num * p) * (1 + Number.EPSILON);
    return Math.round(m) / p;
}