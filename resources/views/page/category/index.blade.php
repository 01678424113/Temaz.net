@extends('layouts.app-2')
@section('content')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Dịch vụ</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <div class="col-md-6 col-sm-12">
                        <div class="dd" id="nestable3">
                            <ol class="dd-list">
                                @if(!empty($categoryParents))
                                    @foreach($categoryParents as $categoryParent)
                                        <li class="dd-item dd3-item" data-id="{{$categoryParent->id}}">
                                            <div class="dd-handle dd3-handle">Drag</div>
                                            <div class="dd3-content" id="dd3-content-{{$categoryParent->id}}">
                                                <button type="button" id="button-{{$categoryParent->id}}"
                                                        data-toggle="collapse"
                                                        data-target="#{{$categoryParent->id}}">
                                                    {{$categoryParent->name}}
                                                </button>
                                            </div>
                                            <form action="{{ route('category.update', $categoryParent->id) }}"
                                                  method="post"
                                                  id="form-{{$categoryParent->id}}"
                                                  class="form-horizontal form-label-left">
                                                @csrf
                                                <div class="box-content" style="padding:0;border:0">
                                                    <div id="{{$categoryParent->id}}" class="collapse">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-12">
                                                                        Dịch vụ cha
                                                                    </label>
                                                                    <div class="col-md-12">
                                                                        {!! Form::select('parent_id', [0 => '...'] + $arrayCategoryParents, old('parent_id'), ['class' => 'form-control select2','disabled'=>'']) !!}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-12" for="">
                                                                        Tên dịch vụ
                                                                        <span class="required">*</span> </label>
                                                                    <div class="col-md-12">
                                                                        <input type="text" required="" id=""
                                                                               name="name"
                                                                               value="{{$categoryParent->name}}"
                                                                               placeholder="" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-12" for="">
                                                                        Slug
                                                                        <span class="required">*</span> </label>
                                                                    <div class="col-md-12">
                                                                        <input type="text" required="" id=""
                                                                               name="slug"
                                                                               value="{{$categoryParent->slug}}"
                                                                               placeholder="" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-12" for="">
                                                                        Sắp xếp
                                                                        <span class="required">*</span> </label>
                                                                    <div class="col-md-12">
                                                                        <input type="number" required id=""
                                                                               name="sort_order"
                                                                               value="{{$categoryParent->sort_order}}"
                                                                               placeholder=""
                                                                               class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="col-md-12">
                                                                        <label class="control-label col-md-12"
                                                                               for=""></label>
                                                                        <input type="button" required id=""
                                                                               data-id="{{$categoryParent->id}}"
                                                                               name=""
                                                                               value="Lưu"
                                                                               placeholder=""
                                                                               class="btn btn-info btn-save-menu">
                                                                        <a href="{{route('category.destroy',$categoryParent->id)}}"
                                                                           class="btn btn-danger">
                                                                            Xóa
                                                                        </a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <ol class="dd-list">
                                                @if(!empty($categoryChildes))
                                                    @foreach($categoryChildes as $categoryChild)
                                                        @if($categoryChild->parent_id == $categoryParent->id)
                                                            <li class="dd-item dd3-item" data-id="16">
                                                                <div class="dd-handle dd3-handle">Drag</div>
                                                                <div class="dd3-content"
                                                                     id="dd3-content-{{$categoryChild->id}}">
                                                                    <button type="button"
                                                                            id="button-{{$categoryChild->id}}"
                                                                            data-toggle="collapse"
                                                                            data-target="#{{$categoryChild->id}}">
                                                                        {{$categoryChild->name}}
                                                                    </button>
                                                                </div>
                                                                <form action="{{ route('category.update', $categoryChild->id) }}"
                                                                      method="post" id="form-{{$categoryChild->id}}"
                                                                      class="form-horizontal form-label-left">
                                                                    @csrf
                                                                    <div class="box-content" style="padding:0;border:0">
                                                                        <div id="{{$categoryChild->id}}"
                                                                             class="collapse">
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-md-12">
                                                                                            Dịch vụ cha
                                                                                        </label>
                                                                                        <div class="col-md-12">
                                                                                            <select name="parent_id"
                                                                                                    class="form-control select2"
                                                                                                    disabled
                                                                                                    id="">
                                                                                                @if(!empty($arrayCategoryParents))
                                                                                                    @foreach($arrayCategoryParents as $key=>$arrayMenuParent)
                                                                                                        <option value="{{$key}}" {{($key == $categoryChild->parent_id) ? 'selected' : ''}}>{{$arrayMenuParent}}</option>
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-md-12"
                                                                                               for="">
                                                                                            Tên dịch vụ
                                                                                            <span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-12">
                                                                                            <input type="text"
                                                                                                   required=""
                                                                                                   id=""
                                                                                                   name="name"
                                                                                                   value="{{$categoryChild->name}}"
                                                                                                   placeholder=""
                                                                                                   class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-md-12"
                                                                                               for="">
                                                                                            Slug
                                                                                            <span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-12">
                                                                                            <input type="text"
                                                                                                   required=""
                                                                                                   id=""
                                                                                                   name="slug"
                                                                                                   value="{{$categoryChild->slug}}"
                                                                                                   placeholder=""
                                                                                                   class="form-control">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label class="control-label col-md-12"
                                                                                               for="">
                                                                                            Sắp xếp
                                                                                            <span class="required">*</span>
                                                                                        </label>
                                                                                        <div class="col-md-12">
                                                                                            <input type="number"
                                                                                                   required
                                                                                                   id=""
                                                                                                   name="sort_order"
                                                                                                   value="{{$categoryChild->sort_order}}"
                                                                                                   placeholder=""
                                                                                                   class="form-control">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <div class="col-md-12">
                                                                                            <label class="control-label col-md-12"
                                                                                                   for=""></label>
                                                                                            <input type="button"
                                                                                                   required id=""
                                                                                                   data-id="{{$categoryChild->id}}"
                                                                                                   name=""
                                                                                                   value="Lưu"
                                                                                                   placeholder=""
                                                                                                   class="btn btn-info btn-save-menu">
                                                                                            <a href="{{route('category.destroy',$categoryChild->id)}}"
                                                                                               class="btn btn-danger">
                                                                                                Xóa
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </ol>
                                        </li>
                                    @endforeach
                                @endif
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h2>Thêm dịch vụ </h2>
                        <form action="{{ route('category.store') }}" method="post"
                              class="form-horizontal form-label-left">
                            @csrf
                            <div class="row">
                                <div class="col-xs-12">
                                    @include('layouts.components.form-html.select2', [
                                        'label' => 'Dịch vụ cha',
                                        'name' => 'parent_id',
                                        'data' => $arrayCategoryParents,
                                        'disabled'=>true
                                    ])
                                </div>
                                <div class="col-xs-12">
                                    @include('layouts.components.form-html.input-text', [
                                        'label' => 'Tên dịch vụ',
                                        'name' => 'name',
                                        'is_required' => true
                                    ])
                                    @include('layouts.components.form-html.input-text', [
                                        'label' => 'Slug',
                                        'name' => 'slug',
                                        'is_required' => true
                                    ])
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            Sắp xếp <span class="required">*</span>
                                        </label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input type="number" required min="1" name="sort_order" value=""
                                                   placeholder="" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <button type="submit" name="btnSubmit" class="btn btn-success">Tạo menu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style type="text/css">
        .cf:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        * html .cf {
            zoom: 1;
        }

        *:first-child + html .cf {
            zoom: 1;
        }

        h1 {
            font-size: 1.75em;
            margin: 0 0 0.6em 0;
        }

        a {
            color: #2996cc;
        }

        a:hover {
            text-decoration: none;
        }

        p {
            line-height: 1.5em;
        }

        .small {
            color: #666;
            font-size: 0.875em;
        }

        .large {
            font-size: 1.25em;
        }

        /**
         * Nestable
         */
        .dd {
            position: relative;
            display: block;
            margin: 0;
            padding: 0;
            list-style: none;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-list {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .dd-list .dd-list {
            padding-left: 30px;
        }

        .dd-collapsed .dd-list {
            display: none;
        }

        .dd-item,
        .dd-empty,
        .dd-placeholder {
            display: block;
            position: relative;
            margin: 0;
            padding: 0;
            min-height: 20px;
            font-size: 13px;
            line-height: 20px;
        }

        .dd-handle {
            display: block;
            height: 30px;
            margin: 5px 0;
            padding: 5px 10px;
            color: #333;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-handle:hover {
            color: #2ea8e5;
            background: #fff;
        }

        .dd-item > button {
            display: block;
            position: relative;
            cursor: pointer;
            float: left;
            width: 25px;
            height: 40px;
            margin: 5px 0;
            padding: 0;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            border: 0;
            background: transparent;
            font-size: 12px;
            line-height: 1;
            text-align: center;
            margin-top: 0;
            font-weight: bold;
            margin-bottom: 0;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            border-radius: 0;
        }

        .dd-item > button:before {
            content: '+';
            display: block;
            position: absolute;
            width: 100%;
            text-align: center;
            text-indent: 0;
        }

        .dd-item > button[data-action="collapse"]:before {
            content: '-';
        }

        .dd-placeholder,
        .dd-empty {
            margin: 5px 0;
            padding: 0;
            min-height: 30px;
            background: #f2fbff;
            border: 1px dashed #b6bcbf;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .dd-empty {
            border: 1px dashed #bbb;
            min-height: 100px;
            background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }

        .dd-dragel {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
        }

        .dd-dragel > .dd-item .dd-handle {
            margin-top: 0;
        }

        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
            box-shadow: 2px 4px 6px 0 rgba(0, 0, 0, .1);
        }

        /**
         * Nestable Extras
         */
        .nestable-lists {
            display: block;
            clear: both;
            padding: 30px 0;
            width: 100%;
            border: 0;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
        }

        #nestable-menu {
            padding: 0;
            margin: 20px 0;
        }

        #nestable-output,
        #nestable2-output {
            width: 100%;
            height: 7em;
            font-size: 0.75em;
            line-height: 1.333333em;
            font-family: Consolas, monospace;
            padding: 5px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        #nestable2 .dd-handle {
            color: #fff;
            border: 1px solid #999;
            background: #bbb;
            background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
            background: -moz-linear-gradient(top, #bbb 0%, #999 100%);
            background: linear-gradient(top, #bbb 0%, #999 100%);
        }

        #nestable2 .dd-handle:hover {
            background: #bbb;
        }

        #nestable2 .dd-item > button:before {
            color: #fff;
        }

        @media only screen and (min-width: 700px) {
            .dd {
                float: left;
                width: 100%;
            }

            .dd + .dd {
                margin-left: 2%;
            }
        }

        .dd-hover > .dd-handle {
            background: #2ea8e5 !important;
        }

        /**
         * Nestable Draggable Handles
         */
        .dd3-content {
            display: flex;
            margin: 5px 0;
            padding: 0;
            color: #333;
            text-decoration: none;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background: linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            font-weight: 500;
            height: 40px;
            padding-top: 9px;
            background: #fbfbfb !important;
            border: 1px solid #ccc;
            border-left: 0;
            border-radius: 0 3px 3px 0px;
        }

        .dd3-content button {
            padding: 0;
            display: block;
            width: 100%;
            background: transparent;
            height: 100%;
            border: 0;
            color: black;
        }

        .dd3-content:hover {
            color: #2ea8e5;
            background: #fff;
        }

        .dd-dragel > .dd3-item > .dd3-content {
            margin: 0;
        }

        .dd3-item > button {
            margin-left: 30px;
        }

        .dd3-handle {
            background: #ddd;
            background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
            background: -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
            background: linear-gradient(top, #ddd 0%, #bbb 100%);
            position: absolute;
            margin: 0;
            left: 0;
            top: 0;
            cursor: pointer;
            width: 30px;
            text-indent: 100%;
            white-space: nowrap;
            overflow: hidden;
            background: #fbfdff;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-color: #e0e0e0;
            height: 40px;
            padding: 5px 10px;
            color: #333;
        }

        .dd3-handle:before {
            content: '≡';
            display: block;
            position: absolute;
            left: 0;
            width: 100%;
            text-align: center;
            text-indent: 0;
            color: #333;
            font-size: 20px;
            font-weight: normal;
        }

        .dd3-handle:hover {
            background: #ddd;
        }

        .control-label {
            margin-top: 10px;
            text-align: left !important;
        }

        .box-content {
            border-radius: 4px;
        }
    </style>

@endpush
@push('scripts')
    <script src="style-menu/jquery.nestable.js"></script>
    <script>
        $('.dd').nestable({
            maxDepth: 2
        });
        $(".collapse").on("show.bs.collapse", function () {
            var id = $(this).attr('id');
            $("#dd3-content-" + id).next().attr('style', 'padding:10px;border: 1px solid #e0e0e0');
        });
        $(".collapse").on("hide.bs.collapse", function () {
            var id = $(this).attr('id');
            $("#dd3-content-" + id).next().attr('style', 'padding:0;border:0');
        });

        $('.btn-save-menu').click(function () {
            var id = $(this).attr('data-id');
            var url = $("#form-" + id).attr('action');
            $.ajax({
                url: url,
                method: 'post',
                data: $("#form-" + id).serialize(),
                success: function (data) {
                    if (data['status']) {
                        $("#button-" + id).html(data['name']);
                        alert(data['message']);
                    } else {
                        alert(data['message']);
                    }
                }
            })
        })


    </script>
@endpush

