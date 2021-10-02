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
                            <div class="col-md-4"> <img class="img" alt="Invoce Template" src="{{ asset('assets/images/logo.png') }}" /> </div>
                            <div class="col-md-8 text-right">
                                <h4><strong>{{ $rent->name }}</strong></h4>
                                <p>{{ $rent->phone }}</p>
                                <p>Invoice date: {{ date('d M, Y') }}</p>
                            </div>
                        </div> <br />
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2>Invoice-AS-{{ $rent->id }}</h2>
                            </div>
                        </div> <br />
                        <div>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td class="col-md-3">Pickup</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->pickup_location }} @if($rent->pickup_datetime != null) at {{ date('d M, Y h:i:s a', strtotime($rent->pickup_datetime)) }} @endif</td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Drop</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->drop_location }} @if($rent->drop_datetime != null) at {{ date('d M, Y h:i:s a', strtotime($rent->drop_datetime)) }} @endif </td>
                                    </tr>
                                    @if($rent->rent_type == 2 && $rent->return_datetime != null)
                                        <tr>
                                            <td class="col-md-3">Return Date & Time</td>
                                            <td class="col-md-2">:</td>
                                            <td class="col-md-7">{{ $rent->drop_location }} at {{ date('d M, Y h:i:s a', strtotime($rent->return_datetime)) }} </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="col-md-3">Car Type</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->CarType->name }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Car Model</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->CarModel->name }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Driver</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->driver->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Reg. No</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->reg_number }}) </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Total Person</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->total_person }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Rent Type</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ getRentType($rent->rent_type) }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Price</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->price }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Advanced</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->advance }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Remaining(Due)</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ (float)($rent->price - $rent->advance) }} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top:80px;">
                            <div class="col-md-12 text-center">
                                <p><b>[No Signature is required. This is an auto generated invoice.]</b></p>
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