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
function getData(path, id , selectBox, selectBoxName, searchValue = -1){
    var urlAddress = ""
    getJSON((id != 0) ? `${baseUrl}/${path}/${id}.json` : `${baseUrl}/propinsi.json`, (err, data) => {
        if (err !== null) {
            alert(`Error : ${err}`);
        } else {
            draw(data, selectBox, selectBoxName, searchValue = -1);
        }
    });
}

function draw(data, selectBox, selectBoxName, searchValue = -1) {
    var selected = " ";
    if(searchValue == -1){
        selected = " ";
    } else {
        selected = "selected";
    }
    console.log(selected);
    clearOption(selectBoxName);
    for (var idx = 0; idx < data.length; idx++) {
        var option;
        // if(searchValue != -1 && searchValue == data[idx].nama){
        //     option = '<option value="' + data[idx].nama + '" data-id="' + data[idx].id + ' ' + selected + '">' + data[idx].nama + "</option>";
        // }
        // else{
            option = '<option value="' + data[idx].nama + '" data-id="' + data[idx].id + '">' + data[idx].nama + "</option>";

        // }
        selectBox.append(option);
    }
}

function drawProvince(id = 0, search = -1) {
    getData("", id, prov, "provinsi", search);
    clearOption("provinsi");
}

function drawCity(id, search = -1) {
    if (id != "" && id != undefined && id != null) {
        getData("kabupaten", id, kota, "provinsi", search);
    }
    else{
        clearOption('provinsi');
    }
}

function drawRegion(id, search = -1) {
    if (id != "" && id != undefined && id != null) {
        getData("kecamatan", id, kec, "kota/kabupaten");
    }
    else{
        clearOption('kota/kabupaten');
    }
}

function selectData(province, city, region) {
    provinceSearch = province;
    citySearch = city;
    regionSearch = region;

    drawProvince(0, province);
    drawCity(city);
    drawRegion(region);
}

// Initalized provinsion
drawProvince();

// Provinsion's OnClick Event
prov.on("change", function(){
    var getId = $(this).find(':selected').attr('data-id')
    drawCity(getId);
});

// City's OnCLick Event
kota.on("change", function(){
    var getId = $(this).find(':selected').attr('data-id')
    drawRegion(getId);
});
