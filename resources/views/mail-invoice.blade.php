<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <!-- Bootstrap Css -->
     <title>Mail Invoice</title>
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <style>
        .invoice--details .border--bottom{
            border-bottom: 1px dashed #878A99 !important;
        }
        .invoice--details .border--top{
            border-top: 1px dashed #878A99;
        }
    
        .invoice--details{
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 12px;
            width: 100%;
        }
        .invoice--details .invoice-card{
            background: transparent;
            box-shadow: none;
            border: 1px solid #878A99;
            border-radius: 0;
            padding: 12px;
        }
        .invoice--details .invoice-card .card-header .invioce-header p{
            font-size: 20px;
            line-height: 27px;
            color: #333;
            white-space: nowrap;
            font-weight: 500;
        }
        /* .invoice--details .invoice-card .card-body table tr th, .invoice--details .invoice-card .card-body table tr td{

        } */
        .invoice--details .invoice-card .card-body table tr th,
        .invoice--details .invoice-card .card-body table tr td{
            padding-left: 0;
            padding-right:0;
            font-size: 18px;
            color: #333;
            line-height: 42px;
        }
        .border--div{
            border: 2px dashed #878A99;
            padding: 1px;
        }
        .invoice--details .invoice-card .card-footer p,
        .invoice--details .invoice-card .card-footer span{
            font-size: 20px;
            line-height: 22px;
            color: #333;
            font-weight: 500;
            text-align: center;
        }
        .invoice--details .invoice-card .signature > .line {
            display: inline-block;
            border-bottom: 1px solid #333333;
            width: 164px;
        }
        .text-left{
            text-align: start;
        }

        .text-end{
            text-align: end;
        }
        .table-row{
            padding: 0.75rem 0.6rem;
        }
    </style>
    
</head>
<body>
    
    <div class="main-content">
        <div class="page-content pt-0">
            <div class="invoice--details">
                <div class="card invoice-card mb-0">
                    <div class="card-header border-0" style="text-align: center; padding:16px;">
                        {{-- background-image: url({{ file_exists(public_path('/storage/'. $printData['logo'])) ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('/storage/'. $printData['logo']))) : '' }}); --}}
                        <img src="{{ file_exists(public_path('/storage/'. $printData['logo'])) ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('/storage/'. $printData['logo']))) : '' }}" alt="" height="17" >
                        
                    </div>
                    <div class="card-header px-0 border--bottom" style="padding: 16px 0">
                        <div class="card-header-inner" style=" display: flex;justify-content: space-between !important;">
                                <div class="invioce-header">
                                    <p style="margin:0px;">Date: {{ $printData['current_date'] }}</p>
                                    <p style="margin:0px;">Table : {{ $printData['table'] }}</p>                                    
                                    <p style="margin:0px;">Customer: {{ $printData['customer_name'] }}</p>
                                </div>
                                <div class="invioce-header text-end" style="margin-left: auto">
                                    <p style="margin:0px;">Time: {{ $printData['current_time'] }}</p>
                                    <p style="margin:0px;">Type : {{ $printData['purchase_type'] }}</p>
                                </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0" style="width: 100%">
                                <thead >
                                    <tr class="table-row">
                                        <th class="text-left" style="font-size:20px;">Item Description</th>
                                        <th class="text-end" style="font-size:20px;">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @foreach($printOrdersData as $data)
                                    <tr class="table-row">
                                            <td class="text-left"> {{$data['quantity']}}X {{$data['name']}}</td>
                                            <td class="text-end" id="cart-subtotal">{{$setting['currency_symbol']}} {{  number_format($data['price'], 2)}}</td>
                                    </tr>
                                    @endforeach

                                    <tr class="table-row ">
                                        <td class="text-left" style="border-bottom: 1px dashed #878a99!important;">Sub total :</td>
                                        <td class="text-end" style="border-bottom: 1px dashed #878a99!important;"> {{$setting['currency_symbol']}} {{number_format($printData['sub_total'], 2)}}</td>
                                    </tr>
                                    @foreach ($printData['taxes'] as $taxId=>$tax)    
                                    <tr>
                                        <td >{{ $tax['name'] }} :</td>
                                        <td class="text-end"> {{$setting['currency_symbol']}} {{number_format($tax['value'],2)}}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="table-row border--top">
                                        <th class="text-left" style="border-bottom: 1px dashed #878a99!important;border-top: 1px dashed #878a99!important;">Total :</th>
                                        <th class="text-end" style="border-bottom: 1px dashed #878a99!important; border-top: 1px dashed #878a99!important;">
                                            <span class="fw-semibold" id="cart-total">
                                                {{$setting['currency_symbol']}} {{number_format($printData['pay_total'],2)}}
                                            </span>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- end table-responsive -->
                    </div>
                    <div class="card-footer pb-1 px-0 text-center">
                        <div class="text-end" style="padding: 10px;">
                            <span class="signature">Signature :<span class="line"></span></span>
                        </div>
                        <div class="border--div mb-2"></div>
                        <p>Closed Bill</p>
                        <p class="mb-0">{{ $printData['footer'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page-content -->
    </div>    
</body>
</html>