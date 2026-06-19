// Call DOM Select Object HTML
var prov = $("#prov");
var kota = $("#city");
var kec = $("#kec");
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

function clearOption(selectBox){
    var prev;
    if(selectBox == 'provinsi'){
        kota.empty();
        kota.append("<option value='' id='-1' disable selected hidden>Silahkan pilih kota</option>");

        kec.empty();
        kec.append("<option value='' id='-1' disable selected hidden>Silahkan pilih kecamatan</option>");
    } else if(selectBox == 'kota/kabupaten'){
        kec.empty();
        kec.append("<option value='' id='-1' disable selected hidden>Silahkan pilih kecamatan</option>");
    }

}

// Generate Select Option
function getData(path, id , selectBox, selectBoxName){
    var urlAddress = ""
    getJSON((id != 0) ? `${baseUrl}/${path}/${id}.json` : `${baseUrl}/propinsi.json`, (err, data) => {
        if (err !== null) {
            alert(`Error : ${err}`);
        } else {
            clearOption(selectBoxName);
            for (var idx = 0; idx < data.length; idx++) {
                var option;
                option = '<option value="' + data[idx].nama + '" data-id="' + data[idx].id + '">' + data[idx].nama + "</option>";
                selectBox.append(option);
            }
        }
    });
}

// Initalized provinsion
getData("", 0, prov, "provinsi");
clearOption("provinsi");

// Provinsion's OnClick Event
prov.on("change", function(){
    var getId = $(this).find(':selected').attr('data-id')

    if (getId != "" && getId != undefined && getId != null) {
        getData("kabupaten", getId, kota, "provinsi");
    }
    else{
        clearOption('provinsi');
    }
});

// City's OnCLick Event
kota.on("change", function(){
    var getId = $(this).find(':selected').attr('data-id')

    if (getId != "" && getId != undefined && getId != null) {
        getData("kecamatan", getId, kec, "kota/kabupaten");
    }
    else{
        clearOption('kota/kabupaten');
    }
});
