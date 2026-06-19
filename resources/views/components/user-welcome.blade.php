<!-- ============================================================== -->
<!-- Presence Button  -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-lg-12">
        <div class="card  bg-light no-card-border">
            <div class="card-body">
                <div class="row">
                  <div class="col-sm-12 col-md-6 my-3">
                    <div class="d-flex align-items-center">
                        <div class="m-r-10" style="font-size:2rem;">
                            <i class="ri-map-pin-time-line text-success"></i>
                        </div>
                        <div>
                            <h3 class="m-b-0">Waktu</h3>
                            <div>{{date("l, d F Y")}}</div>
                            <x-live-clock />
                        </div>
                    </div>
                  </div>
                  <div class="col-sm-12 col-md-6 my-3">
                    <div class="text-right">
                        <div class="col-sm-12 col-md-8 col-lg-8 text-center ml-auto alert alert-success" role="alert">
                            Anda sudah melakukan absensi hari ini!
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
