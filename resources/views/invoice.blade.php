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
                                        <td class="col-md-7">{{ $rent->pickup_location }} at {{ date('d M, Y', strtotime($rent->pickup_datetime)) }} </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-3">Drop</td>
                                        <td class="col-md-2">:</td>
                                        <td class="col-md-7">{{ $rent->drop_location }} at {{ date('d M, Y', strtotime($rent->drop_datetime)) }} </td>
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
                                        <td class="col-md-3">Due</td>
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
    </body>
</html>