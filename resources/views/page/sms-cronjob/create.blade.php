@extends('layouts.app-2')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Đặt lịch SMS</h2>
                    <ul class="nav navbar-right panel_toolbox" style="display: flex;justify-content: flex-end;">
                        <li><a href="{{route('sms-cronjob.create')}}" style="color:#26B99A;"><i class="fa fa-plus"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <form action="{{route('sms-cronjob.store')}}" method="post" enctype="multipart/form-data"
                      id="form-send-sms">
                    @csrf
                    <div class="x_content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Campaign:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                                <select class="form-control select_campaign" name="campaign_id" id="" required>
                                                    @if(!empty($arrayCampaigns))
                                                        @foreach($arrayCampaigns as $key=>$arrayCampaign)
                                                            <option value="{{$key}}">{{$arrayCampaign}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Tên
                                            </label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <input type="text" class="form-control" name="name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 10px">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Thời gian:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                                <select class="form-control" name="time" id="" required>
                                                    <option value="1">1</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="30">10</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for=""></label>
                                            <div class="col-md-9 col-sm-6 col-xs-12 form-group has-feedback">
                                                <button class="btn btn-success btn-send" type="submit">Đặt lịch</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Upload file:
                                            </label>
                                            <div class=" col-md-7 col-sm-7 col-xs-10">
                                                <input type="file" name="file_phone" class="form-control">
                                            </div>
                                            <div class=" col-md-2 col-sm-2 col-xs-2">
                                                <a href="/home/temaz.net/public_html/PhoneSample.xlsx" download class="btn btn-success add_sample_sms"><i
                                                            class="fa fa-download"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                                                Nhập số điện thoại:
                                            </label>
                                            <div class=" col-md-9 col-sm-9 col-xs-12">
                                            <textarea name="text_phone" id="" cols="30" rows="10" required
                                                      class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')

@endsection

