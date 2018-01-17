<div class="fiter-panel-toggle">
  <button id="fiter_panel_toggle" type="button" class="btn btn-primary btn-block br0"><i class="fa fa-search"></i>&nbsp;กรองการค้นหา</button>
</div>

<div class="left-sidenav">

  <button type="button" class="close" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>

  <div class="pa3 mb4">

    {{Form::open(['id' => 'ticket_filter_form', 'method' => 'get', 'enctype' => 'multipart/form-data'])}}

    <h4 class="my-2">ค้นหา</h4>

    <div>
      <div class="row">
        @foreach($categories as $key => $category)
        <div class="col-12">
          <div class="c-input">
            {{Form::checkbox('category[]', $category->id, false, array('id' => 'cat'.$key))}}
            <label for="cat{{$key}}">
              {{$category->name}}
            </label>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    <div class="mt-2">
      {{ Form::text('q', null, array(
        'id' => 'q',
        'class' => 'w-100 p-2',
        'placeholder' => 'ชื่อบัตร สถานที่ หรือ คำค้นอื่นๆ',
        'autocomplete' => 'off'
      )) }}
    </div>

    <div class="mt-4">

      <h4 class="my-2">ราคา</h4>

      <div class="price-filter-box clearfix">
        {{ Form::text('price_start', null, array(
          'id' => 'price_start',
          'class' => 'w-50 p-2 fl',
          'placeholder' => 'ราคาเริ่มต้น',
          'autocomplete' => 'off'
        )) }}
        {{ Form::text('price_end', null, array(
          'id' => 'price_end',
          'class' => 'w-50 p-2 fl',
          'placeholder' => 'สูงสุด',
          'autocomplete' => 'off'
        )) }}
      </div>

    </div>

    <div class="mt-4">
      <h4 class="my-2">ค้นหาตามพื่นที่</h4>

      <div class="selecting-lable-box">
        <div id="location_label" class="selected-value" data-toggle="modal" data-c-modal-target="#selecting_location" data-selecting-empty-label="เลือกพื่นที่">
          เลือกพื่นที่
        </div>
        
        <a class="selected-value-delete">
          <span aria-hidden="true">&times;</span>
        </a>
      </div>
    </div>

    <div class="mt-4">
      <h4 class="my-2">ช่วงเวลาการใช้งานของบัตร</h4>
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </span>
        {{Form::text('start_date', null, array(
        'id' => 'start_date', 
        'class' => 'form-control w-100 p-2', 
        'placeholder' => 'เริ่มต้น',
        'autocomplete' => 'off', 
        'readonly' => 'true'))}}
      </div>

      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </span>
        {{Form::text('end_date', null, array('id' => 'end_date', 'class' => 'form-control w-100 p-2', 'placeholder' => 'ถึง', 'autocomplete' => 'off', 'readonly' => 'true'))}}
      </div>
    </div>

    <div class="mt-4 mb-3">
      <h4 class="my-2">เรียง</h4>
      <div>
        <div class="c-input">
          {{Form::radio('sort', 'post_n', false, array('id' => 'sort1', 'checked' => true))}}
          <label for="sort1">
            ประกาศ - ใหม่ไปเก่า
          </label>
        </div>
        <div class="c-input">
          {{Form::radio('sort', 'post_o', false, array('id' => 'sort2'))}}
          <label for="sort2">
            ประกาศ - เก่าไปใหม่
          </label>
        </div>
        <div class="c-input">
          {{Form::radio('sort', 'price_h', false, array('id' => 'sort3'))}}
          <label for="sort3">
            ราคา - สูงไปต่ำ
          </label>
        </div>
        <div class="c-input">
          {{Form::radio('sort', 'price_l', false, array('id' => 'sort4'))}}
          <label for="sort4">
            ราคา - ต่ำไปสูง
          </label>
        </div>
        <div class="c-input">
          {{Form::radio('sort', 'card_date', false, array('id' => 'sort5'))}}
          <label for="sort5">
            วันที่ใช้งานของบัตร
          </label>
        </div>
      </div>
    </div>

    <div class="text-center mt-2">
      <button id="ticket_fiter_btn" type="submit" class="btn btn-primary btn-block br0">ค้นหา</button>
    </div>

    <div id="selecting_location" class="c-modal">
      <a class="close"></a>
      <div class="c-modal-sidebar-inner show-left h-100">

        <a class="modal-close">
          <span aria-hidden="true">&times;</span>
        </a>

        <div class="list-item-panel selecting-list"></div>
        <div class="selecting-action">
          <div class="selecting-action-inner mv2">
            <small class="mb2">เส้นทาง</small>
            <h5 class="selecting-lable mb2">...</h5>
          </div>
        </div>
      </div>
      {{ Form::hidden('location') }}
    </div>

    {{Form::close()}}

  </div>

</div>