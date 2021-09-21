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
                                <h4><strong>Suman Ahmed</strong></h4>
                                <p>6 June 2019</p>
                                <p>Tejgaon, Dhaka-1212</p>
                                <p>example@gmail.com</p>
                            </div>
                        </div> <br />
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2>INVOICE</h2>
                                <h5>04854654101</h5>
                            </div>
                        </div> <br />
                        <div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="col-md-7">Product Name</th>
                                        <th class="col-md-2">Quantity</th>
                                        <th class="col-md-3">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="col-md-7">Babay Diaper</td>
                                        <td class="col-md-2">3</td>
                                        <td class="col-md-3">50,000 </td>
                                    </tr>
                                    <tr>
                                        <td class="col-md-7">Food</td>
                                        <td class="col-md-2">4</td>
                                        <td class="col-md-3">5,200 </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2">
                                            <strong>Sub Total:</strong>
                                        </td>
                                        <td class="text-left">
                                            <strong>79,900 </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2">
                                            <strong>Discount:</strong>
                                        </td>
                                        <td class="text-left">
                                            <strong>100 </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2">
                                            <strong>Delivery Charge:</strong>
                                        </td>
                                        <td class="text-left">
                                            <strong>100 </strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="2">
                                            <strong>Total Payable Amount:</strong>
                                        </td>
                                        <td class="text-left">
                                            <strong>79,900 </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="col-md-12">
                                <p><b>Signature</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>