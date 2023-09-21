@extends('admin.layout.app')

@section('content')

    <!-- Begin Body -->
    <div class="main-panel">
        @includeif('admin.layout.navbar')
        <div class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ $title }}</h4>
                            {{-- <p class="card-category">Complete your profile</p> --}}
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row bordercss">
                                    <div class="col-md-2">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Series*</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Supplier*</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Company*</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Date*</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-2  ">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Required By</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Address and Contact</h6>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Supplier Address</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Supplier Contact</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Company Shipping Address
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Place of Supply</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Shipping Address Details</label>

                                            <textarea class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Company GSTIN</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Company Billing Address
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Billing Address Details
                                            </label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>
                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Currency and Price List </h6>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Currency*</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Price List</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Price List Currency</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Price List Exchange Rate</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Subcontracting </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="">Supply Raw Materials</label>

                                            <select class="form-control">
                                                <option>No</option>
                                                <option>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                      <div class="form-group bmd-form-group">
                                      <label class="bmd-label-floating">Supply Raw Materials</label>
                                      <input type="text" class="form-control">
                                     <input type="text" class="form-control">
                                        </div>
                                         </div> --}}
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Set Target Warehouse
                                            </label>
                                            <input type="text" class="form-control">
                                            Sets 'Warehouse' in each row of the Items table.
                                        </div>
                                    </div>
                                </div>

                                <div class="row bordercss">

                                    <div class="col-md-12">
                                        <h6>Items </h6>
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="stockledger" class="table table-striped table-bordered"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Item Code</th>
                                                                <th>Item Name </th>
                                                                <th>Quantity</th>
                                                                <th>Stock Value</th>
                                                                <th>UOM</th>
                                                                <th>Rate (INR)</th>
                                                                <th>Rate Review Remarks</th>
                                                                <th>Weight Details</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            </tr>

                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row bordercss">
                                    <div class="col-md-6">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Total Quantity
                                            </label>
                                            <input type="text" class="form-control" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Total (INR) </label>
                                            <input type="text" class="form-control" value="0.00 INR">
                                        </div>
                                    </div>
                                </div>
                                <div class="row bordercss">
                                    <div class="col-md-6">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Tax Category</label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Shipping Rule
                                            </label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>


                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Additional Discount </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Apply Additional Discount On</label>
                                            <select class="form-control">
                                                <option selected></option>
                                                <option>Grand Total</option>
                                                <option>Net Total</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Additional Discount Percentage</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Additional Discount Amount (INR)</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div>

                                </div>

                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Totals</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Grand Total (INR)</label>
                                            <input type="text" class="form-control" value="0.00 INR">
                                        </div>
                                    </div>

                                </div>

                                <div class="row bordercss">
                                    <div class="col-md-4">
                                        <h6>Payments Terms</h6>
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Payment Terms Template
                                            </label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <h6>Items </h6>
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="stockledger" class="table table-striped table-bordered"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Payment Term</th>
                                                                <th>Description</th>
                                                                <th>Due Date</th>
                                                                <th>Invoice Portion</th>
                                                                <th>Payment Amount (INR)</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            </tr>

                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Order Status </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Status*</label>
                                            <input type="text" class="form-control" value="Draft">
                                        </div>
                                    </div>

                                </div>
                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Terms and Conditions </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Terms</label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Terms and Conditions</label>
                                            <textarea class="form-control" rows="5">Editor here</textarea>
                                        </div>
                                    </div>

                                </div>

                                <div class="row bordercss">
                                    <div class="col-md-12">
                                        <h6>Printing Settings </h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Letter Head
                                            </label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Print Language</label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group bmd-form-group">
                                            <label class="bmd-label-floating">Print Heading
                                            </label>
                                            <input type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                </div>

                                <div class="row bordercss">
                                  <div class="col-md-12">
                                      <h6>Subscription Section  </h6>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">From Date
                                          </label>
                                          <input type="text" class="form-control" value="">
                                      </div>
                                  </div>

                                  <div class="col-md-4">
                                      <div class="form-group bmd-form-group">
                                          <label class="bmd-label-floating">To Date</label>
                                          <input type="text" class="form-contro	0l" value="">
                                      </div>
                                  </div>
                                  
                              </div>

                        </div>
                    </div>

                    {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>About Me</label>
                                            <div class="form-group bmd-form-group">
                                                <label class="bmd-label-floating"> Lamborghini Mercy, Your chick she so
                                                    thirsty, I'm in that two seat Lambo.</label>
                                                <textarea class="form-control" rows="5"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                    <button type="submit" class="btn btn-primary pull-right">Update Profile</button>
                    <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>
    <script>
        $("#checkAll").click(function() {
            $(".check").prop('checked', $(this).prop('checked'));
        });
    </script>
@endsection
