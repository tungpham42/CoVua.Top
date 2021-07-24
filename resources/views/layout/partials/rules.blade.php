<div class="container-fluid about px-0 font-weight-bold text-center pb-5">
  <button type="button" class="btn btn-dark btn-lg" data-toggle="modal" data-target="#GuideModal">
    <i class="fad fa-info-circle"></i> Hướng dẫn
  </button>
</div>
<div class="modal fade" id="GuideModal" tabindex="-1" role="dialog" aria-label="Guide" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title">Hướng dẫn</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Có 4 chế độ: Chơi với nhau, Chơi với máy, Chơi trong phòng, và Cờ thế</p>
        <ol>
          <li><u>Chơi với nhau:</u> Kì thủ ấn vào nút <a target="_blank" href="{{ URL::to('/choi-voi-nhau') }}">"CHƠI VỚI NHAU"</a> trên trang chủ và bắt đầu luyện tập với nhau. </li>
          <li><u>Chơi với máy:</u> Kì thủ <strong><em>chơi cờ vua với máy</em></strong> ngay trên trang chủ. Có 5 cấp độ: <a target="_blank" href="{{ url('/moi-choi') }}">Mới chơi</a>, <a target="_blank" href="{{ url('/de') }}">Dễ</a>, <a target="_blank" href="{{ url('/binh-thuong') }}">Bình thường</a>, <a target="_blank" href="{{ url('/kho') }}">Khó</a>, và <a target="_blank" href="{{ url('/kho-nhat') }}">Khó nhất</a>.</li>
          <li><u>Chơi trong phòng:</u> Kì thủ ấn vào nút "TẠO PHÒNG MỚI", mở một phòng mới với Mã phòng bất kỳ và tạo một Mật khẩu chỉ có bạn biết thôi, đồng thời có thể Mời bạn bè vào chơi qua đường link và chia sẻ mật khẩu cho bạn cùng chơi. Kì thủ cũng có thể vào trang <a target="_blank" href="{{ URL::to('/danh-sach-phong') }}">"Danh sách phòng"</a> để truy cập vào 1 phòng có sẵn. Trong trang này kì thủ có thể lựa chọn Quân Đỏ hoặc Quân Đen. Quân Đỏ đi trước.</li>
          <li><u>Cờ thế:</u> Dành cho các kỳ thủ, người đã biết chơi cờ lão luyện. Kỳ thủ ấn vào nút <a target="_blank" href="{{ url('/xep-co') }}">"Xếp cờ"</a> trên trang chủ, sau đó di chuyển và bày trận theo ý của mình, nhấn nút "CHỤP BÀN CỜ THẾ" và mời bạn bè cùng giải cờ thế.</li>
        </ol>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>