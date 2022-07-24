<html>
    <head>
        <title>Invoice</title>
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/inovice.css') }}" />
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 body-main">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4"> 
                                    <img class="img" alt="Invoce Template" src="{{ asset('assets/images/logo.png') }}" />
                                    <h3>Autospire Logistics</h3>
                                    <p>150/1, Crescent Homes, Mirpur-1, Dhaka 1216</p>
                                    <p>01912278827 / 01611822829</p>
                                    <p>autospirebd@gmail.com</p>
                            </div>
                            <div class="col-md-8 text-right">
                                <h3>Let us take you away!</h3>
                                <p>Print date: {{ date('d M, Y') }}</p>
                                <p>Invoice-AS-{{ $rent->id }}</p>
                                <p><strong>{{ $rent->name }}, {{ $rent->phone }}</strong></p>
                            </div>
                        </div> 
                        <div class="row body-content">
                            <div class="col-md-12">
                                <p>Dear <strong>{{ $rent->name }}</strong>,</p><br/>
                                <p>Please find below the rental cost with explanation. Please make payment at your earliest
                                convenience, and do not hesitate to contact us with any questions.</p><br/>
                                <p>Many Thanks,</p>
                                <p>Autospire Logistics</p> <br/>
                                <p>Travel Date : {{ date('d M, Y h:i:s a', strtotime($rent->pickup_datetime)) }}</p>
                                @if($rent->rent_type == 2)
                                    <p>Return Date : {{ date('d M, Y h:i:s a', strtotime($rent->return_datetime)) }} </p>
                                @endif
                                <br/>
                            </div>
                        </div>
                        <div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="col-md-3 text-center">Rental Description</th>
                                        <th class="col-md-7 text-center">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-6">Pickup</td>
                                        <td class="col-md-6">{{ $rent->pickup_location }} @if($rent->pickup_datetime != null) at {{ date('d M, Y h:i:s a', strtotime($rent->pickup_datetime)) }} @endif</td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-6">Drop</td>
                                        <td class="col-md-6">{{ $rent->drop_location }} @if($rent->drop_datetime != null) at {{ date('d M, Y h:i:s a', strtotime($rent->drop_datetime)) }} @endif </td>
                                    </tr>
                                    @if($rent->rent_type == 2 && $rent->return_datetime != null)
                                        <tr>
                                            <td class="col-md-6">Return Date & Time</td>
                                            <td class="col-md-6">{{ date('d M, Y h:i:s a', strtotime($rent->return_datetime)) }} </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="col-md-6">Car Type</td>
                                        <td class="col-md-6">{{ $rent->CarType->name }} </td>
                                    </tr>
                                    @if($rent->driver_id != null)
                                        <tr>
                                            <td class="col-md-6">Driver</td>
                                            <td class="col-md-6">{{ $rent->driver->name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-6">Reg. No</td>
                                            <td class="col-md-6">{{ $rent->reg_number }}) </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="col-md-6">Total Person</td>
                                        <td class="col-md-6">{{ $rent->total_person }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-6">Rent Type</td>
                                        <td class="col-md-6">{{ getRentType($rent->rent_type) }} </td>
                                    </tr>
                                </tbody>
                                <tfoot style="font-weight: 700">
                                    <tr>
                                        <td class="col-md-6">Price</td>
                                        <td class="col-md-6 text-right">{{ $rent->price }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-6">Advanced</td>
                                        <td class="col-md-6 text-right">{{ $rent->advance }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-6">Due</td>
                                        <td class="col-md-6 text-right">{{ (float)($rent->price - $rent->advance) }} </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row body-content">
                            <div class="col-md-12">
                                <p>Many thanks for your Booking! We look forward to doing business with you again in due
                                    course.</p><br/>
                                <p>Payment Terms: Pay to our Bank Account / Bkash payment / Cash</p>
                                <p>Brac Bank Limited</p>
                                <p>Account name : Autospire</p>
                                 <p>AC/NO: 1538204467297001</p> <br/>
                                <p>Bkash Merchant : Autospire</p>
                                <p>Bkash Number : 01912278827</p><br/>
                                <p><strong>(Note: Please do not hire bus from driver to avoid money loss, different bus and commitement issues)</strong></p><br/>
                                @if($rent->note != null)
                                    <p><strong>[Extra Note: {{ $rent->note }}]</strong></p><br/>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top:40px;">
                            <div class="col-md-12 text-center">
                                <p><b>[No Signature is required. This is an auto generated invoice]</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php
            function getRentType ($type) {
                if ($type == 1) {
                    echo "Drop Only";
                } else if ($type == 2) {
                    echo "Round Trip";
                } else if ($type == 3) {
                    echo "Body Rent";
                } else if ($type == 4) {
                    echo "Monthly";
                }
            }
        ?>
    </body>
</html>