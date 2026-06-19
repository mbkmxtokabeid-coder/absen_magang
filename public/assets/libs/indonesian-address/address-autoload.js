$(document).ready(function(){

    // Call DOM Select Object HTML
    var prov = $("#province");
    var kota = $("#region");
    var kec = $("#sub_district");
    var postal = null;
    var baseUrl = "../../assets/libs/indonesian-address";

    // Get JSON File Function
    var getJSON = function (url, callback) {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", url, true);
      xhr.responseType = "json";
      xhr.onload = function () {
        var status = xhr.status;
        if (status === 200) {
          callback(null, xhr.response);
        } else {
          callback(status, xhr.response);
        }
      };
      xhr.send();
    };

    function clearOption(selectBox, searchValue = -1){
        var prev;
        if(selectBox == 'provinsi'){
            kota.empty();
            if(searchValue == -1){
                kota.append("<option value='' id='-1' disable selected hidden>Silahkan pilih kota</option>");
            }

            kec.empty();
            if(searchValue == -1){
                kec.append("<option value='' id='-1' disable selected hidden>Silahkan pilih kecamatan</option>");
            }
        } else if(selectBox == 'kota/kabupaten'){
            kec.empty();
            if(searchValue == -1){
                kec.append("<option value='' id='-1' disable selected hidden>Silahkan pilih kecamatan</option>");
            }
        }

    }
    var idJson = -1;
    // Generate Select Option
    function getData(path, id , selectBox, selectBoxName, searchValue = -1){
        var urlAddress = ""
        var selected = " ";
        if(searchValue != -1){
            selected = "selected";
        }
        getJSON((id != 0) ? `${baseUrl}/${path}/${id}.json` : `${baseUrl}/propinsi.json`, (err, data) => {
            if (err !== null) {
                alert(`Error : ${err}`);
            } else {
                clearOption(selectBoxName,searchValue);
                for (var idx = 0; idx < data.length; idx++) {
                    var option;
                    option = '<option value="' + data[idx].nama + '" data-id="' + data[idx].id + '" '+ selected +'>' + data[idx].nama + "</option>";
                    selectBox.append(option);
                    idJson = data[idx].id;
                }
            }
        });
    }

    function drawProvince(id = 0, search = -1) {
        if(search == -1){
            prov.append("<option value='' id='-1' disable selected hidden>Silahkan pilih provinsi</option>")
        }
        getData("", 0, prov, "provinsi");
        clearOption("provinsi", search);
        // if()
        $('#province option[value="RIAU"]').prop('selected', true);
    }

    function drawCity(id, search = -1) {
        if (id != "" && id != undefined && id != null) {
            getData("kabupaten", id, kota, "provinsi", search);
        }
        else{
            clearOption('provinsi', search);
        }
    }

    function drawRegion(id, search = -1) {
        if (id != "" && id != undefined && id != null) {
            getData("kecamatan", id, kec, "kota/kabupaten");
        }
        else{
            clearOption('kota/kabupaten', search);
        }
    }

    function getIdElement(element) {
        var getId = $(element).find(':selected').attr('data-id')

        return getId;
    }

    function selectData(province, city, sub_district){
        // drawProvince(0, "SUMATERA UTARA");
        prov.val(province);
        console.log(getIdElement(prov))
    }

    // Initalized provinsion
    prov.empty();
    drawProvince();

    // Provinsion's OnClick Event
    prov.on("change", function(){
        var getId = getIdElement($(this))
        drawCity(getId);
    });

    // City's OnCLick Event
    kota.on("change", function(){
        var getId = getIdElement($(this))

        drawRegion(getId);
    });

})
