<div class="fiter-panel-toggle">
  <button id="fiter_panel_toggle" type="button" class="btn btn-primary btn-block br0"><i class="fa fa-search"></i>&nbsp;กรองการค้นหา</button>
</div>

<div class="left-sidenav">

  <button type="button" class="close" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>

  <div class="p-3 mb5">

    {{Form::open(['method' => 'get', 'enctype' => 'multipart/form-data'])}}

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

      <div class="my-3">
        {{ Form::text('q', null, array(
          'class' => 'w-100 p-2',
          'placeholder' => 'ชื่อบัตร, สถานที่, คำค้นอื่นๆ',
          'autocomplete' => 'off'
        )) }}
      </div>

      <div class="mb-3">
        <h4 class="my-2">ราคา</h4>
        <div class="mb-2 clearfix">
          <small class="fl"><strong id="price_range_min">1</strong>&nbsp;บาท</small>
          <small class="fr"><strong id="price_range_max">50000</strong>&nbsp;บาท</small>
        </div>
        <div class="price-range text-center">
          <input id="price_range_slider" data-slider-id='price_range' type="text" data-slider-min="1" data-slider-max="50000" data-slider-step="5" data-slider-value="[1,50000]"/>
        </div>
      </div>

      <div class="mb-3">
        <h4 class="my-2">วันที่</h4>
        <div class="input-group">
          <span class="input-group-addon" id="location-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {{Form::text('date_1', null, array(
          'id' => 'date_input_1', 
          'class' => 'form-control w-100 p-2', 
          'placeholder' => 'เริ่มต้น',
          'autocomplete' => 'off', 
          'readonly' => 'true'))}}
        </div>

        <div class="input-group">
          <span class="input-group-addon" id="location-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {{Form::text('date_2', null, array('id' => 'date_input_2', 'class' => 'form-control w-100 p-2', 'placeholder' => 'ถึง', 'autocomplete' => 'off', 'readonly' => 'true'))}}
        </div>
      </div>      

      <div class="text-center mt-2">
        <button type="submit" class="btn btn-primary btn-block br0">ค้นหา</button>
      </div>

    {{Form::close()}}

  </div>
</div>