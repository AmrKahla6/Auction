
<div class="modal" id="exampleModal2">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضف الي الاسلايدر</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
            <form action="{{route('dashboard.auction.slider-store')}}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="id" id="id" value="">
                <div class="form-group">
                    <label>الوصف بالعربيه</label>
                    <textarea name="desc_ar" id=""  class="form-control ckeditor" cols="30" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label>الوصف بالانجليزيه</label>
                    <textarea name="desc_en" id=""  class="form-control ckeditor" cols="30" rows="10"></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn ripple btn-primary" type="submit" id="Addsection"> حفظ البيانات </button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
