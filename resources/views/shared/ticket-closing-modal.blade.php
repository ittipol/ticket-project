<div id="closing_item_modal" class="c-modal">
  <a class="close"></a>
  <div class="c-modal-inner">

    <a class="modal-close">
      <span aria-hidden="true">&times;</span>
    </a>

    <h4 class="item-title f4 f3-ns mb-3 mb4-ns"></h4>

    <h5 class="f5"><strong>คุณปิดประกาศนี้เพราะ</strong>?</h5>

    {{Form::open(['url' => '/item/close', 'id' => 'closing_item_form', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}
      <div class="row">
        <div class="col-md-4 md-radio tc-ns">
          <input id="closing_option_1" class="close-option" type="radio" value="1" name="closing_option" checked>
          <label for="closing_option_1">ขายสินค้านี้แล้ว</label>
        </div>
        <div class="col-md-4 md-radio tc-ns">
          <input id="closing_option_2" class="close-option" type="radio" value="2" name="closing_option">
          <label for="closing_option_2">ยกเลิกการขาย</label>
        </div>
        <div class="col-md-4 md-radio tc-ns">
          <input id="closing_option_3" class="close-option" type="radio" value="3" name="closing_option">
          <label for="closing_option_3">เหตุผลอื่น</label>
        </div>
      </div>

      <textarea id="closing_reason" class="modal-textarea form-control w-100 mt3" name="closing_reason"></textarea>
      <small>โปรดระบุเหตุผล</small>
      <button type="submit" class="btn btn-primary btn-block br0 mt3">ตกลง</button>
    {{Form::close()}}

  </div>
</div>

<script type="text/javascript" src="/assets/js/item-close.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    const _itemClose = new TicketClose();
    _itemClose.init();
  });
</script>
