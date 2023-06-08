@extends('layout.layout')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class='bx bx-network-chart bx-border' style="font-size:25px;color:#0c5598;"></i>
                    </div>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="cardOpt1">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Total Services</span>
                  <h3 class="card-title mb-2">{{$total_services}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class='bx bxl-blogger bx-border' style="font-size:25px;color:#f26706;"></i>
                    </div>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="cardOpt1">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Total Blogs</span>
                  <h3 class="card-title mb-2">{{$total_blogs}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class='bx bx-user-plus bx-border' style="font-size:25px;color:#8b0785;"></i>
                    </div>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="cardOpt1">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Total Candidates</span>
                  <h3 class="card-title mb-2">{{$total_candidates}}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                  <div class="card-title d-flex align-items-start justify-content-between">
                    <div class="avatar flex-shrink-0">
                        <i class='bx bx-box bx-border' style="font-size:25px;color:#076e75;"></i>
                    </div>
                    <div class="dropdown">
                      <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-dots-vertical-rounded"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="cardOpt1">
                        <a class="dropdown-item" href="javascript:void(0);">View More</a>
                      </div>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Total Products</span>
                  <h3 class="card-title mb-2">{{$total_products}}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

