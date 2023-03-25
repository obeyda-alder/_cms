@extends('backend.layouts.cms_http')

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
@endsection

@section('content')
<div class="dashboard row">
    <div class="col-lg-6 grid-margin stretch-card separator-1">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ __('base.dashboard_statistic.users_count_with_status') }}</h4>
                <div class="ct-chart ct-perfect-fourth" id="ct-chart-donut"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ __('base.dashboard_statistic.packing_order_count_with_status') }}</h4>
            <div class="ct-chart ct-perfect-fourth" id="ct-chart-pie"></div>
          </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 separator"></div>
    <div class="col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">{{ __('base.dashboard_statistic.units') }}</h4>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Product</th>
                    <th>Sale</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Jacob</td>
                    <td>Photoshop</td>
                    <td class="text-danger"> 28.76% <i class="icon-arrow-down-circle"></i></td>
                    <td><label class="badge badge-danger">Pending</label></td>
                </tr>
                <tr>
                    <td>Messsy</td>
                    <td>Flash</td>
                    <td class="text-danger"> 21.06% <i class="icon-arrow-down-circle"></i></td>
                    <td><label class="badge badge-warning">In progress</label></td>
                </tr>
                <tr>
                    <td>John</td>
                    <td>Premier</td>
                    <td class="text-danger"> 35.00% <i class="icon-arrow-down-circle"></i></td>
                    <td><label class="badge badge-info">Fixed</label></td>
                </tr>
                <tr>
                    <td>Peter</td>
                    <td>After effects</td>
                    <td class="text-success"> 82.00% <i class="icon-arrow-up-circle"></i></td>
                    <td><label class="badge badge-success">Completed</label></td>
                </tr>
                <tr>
                    <td>Dave</td>
                    <td>53275535</td>
                    <td class="text-success"> 98.05% <i class="icon-arrow-up-circle"></i></td>
                    <td><label class="badge badge-warning">In progress</label></td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 separator"></div>
    <div class="col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">{{ __('base.dashboard_statistic.money') }}</h4>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th> User </th>
                  <th> First name </th>
                  <th> Progress </th>
                  <th> Amount </th>
                  <th> Deadline </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-1.png" alt="image" />
                  </td>
                  <td> Herman Beck </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $ 77.99 </td>
                  <td> May 15, 2015 </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-2.png" alt="image" />
                  </td>
                  <td> Messsy Adam </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $245.30 </td>
                  <td> July 1, 2015 </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-3.png" alt="image" />
                  </td>
                  <td> John Richards </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $138.00 </td>
                  <td> Apr 12, 2015 </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-4.png" alt="image" />
                  </td>
                  <td> Peter Meggik </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $ 77.99 </td>
                  <td> May 15, 2015 </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-1.png" alt="image" />
                  </td>
                  <td> Edward </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $ 160.25 </td>
                  <td> May 03, 2015 </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-2.png" alt="image" />
                  </td>
                  <td> John Doe </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $ 123.21 </td>
                  <td> April 05, 2015 </td>
                </tr>
                <tr>
                  <td class="py-1">
                    <img src="../../images/faces-clipart/pic-3.png" alt="image" />
                  </td>
                  <td> Henry Tom </td>
                  <td>
                    <div class="progress">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td> $ 150.00 </td>
                  <td> June 16, 2015 </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.dashboard{
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px
}
.dashboard h4 {
    margin-bottom: 10px;
    display: inline-block;
    border-bottom: 1px solid black;
    padding-bottom: 2px;
}
.separator-1{
    border-right: 1px solid rgb(199 182 182 / 75%);
    border-width: 2px;
}
.separator{
    width: 100%;
    height: 2px;
    margin: 50px 0;
    background-color: rgb(199 182 182 / 75%)
}
.ct-series-d .ct-area, .ct-series-d .ct-slice-donut-solid, .ct-series-d .ct-slice-pie {
    fill: #d98e2b;
}
</style>
@endpush
@push('scripts')
<script>
    $(function() {
        var sum = function(a, b) { return a + b };
        //Donut
        var labels = ['safari', 'chrome', 'explorer', 'firefox'];
        var data = { series: [20, 40, 10, 30] };
        if ($('#ct-chart-donut').length) {
            new Chartist.Pie('#ct-chart-donut', data, {
            donut: true,
            donutWidth: 75,
            donutSolid: true,
            startAngle: 70,
            showLabel: true,
            labelInterpolationFnc: function(value, index) {
                var percentage = Math.round(value / data.series.reduce(sum) * 100) + '%';
                return labels[index] + ' ' + percentage;
            }
            });
        }
        //Pie
        if ($('#ct-chart-pie').length) {
            var data = { series: [5, 3, 4] };
            new Chartist.Pie('#ct-chart-pie', data, {
            labelInterpolationFnc: function(value) {
                return Math.round(value / data.series.reduce(sum) * 100) + '%';
            }
            });
        }
    });
</script>
@endpush
