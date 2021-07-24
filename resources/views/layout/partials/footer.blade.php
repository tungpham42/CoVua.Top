<footer>
  <div class="container">
    <div class="row p-5">
      <div class="col-12 col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3 vcard">
        <p>Email liên hệ</p>
        <a class="w-100 email" href="mailto:tung.42@gmail.com">tung.42@gmail.com</a>
        <p class="mt-3"><i class="fal fa-copyright"></i> Bản quyền <a class="url fn" target="_blank" href="https://tungpham42.info/">Phạm Tùng</a></p>
      </div>
      <div class="col-12 col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
        <ul class="list-unstyled">
          <li>
            <a class="home" href="{{ url('/') }}"><i class="fal fa-home-lg-alt"></i> Trang chủ</a>
          </li>
          <li>
            <a class="room" href="{{ url('/danh-sach-phong') }}"><i class="fal fa-th-list"></i> Danh sách phòng</a>
          </li>
          <li>
            <a class="setup" href="{{ url('/xep-co') }}"><i class="fal fa-camera-retro"></i> Xếp cờ</a>
          </li>
          <li>
            <a class="about" href="{{ url('/gioi-thieu') }}"><i class="fal fa-info-square"></i> Giới thiệu</a>
          </li>
          <li>
            <a class="contact" href="{{ url('/lien-he') }}"><i class="fal fa-envelope"></i> Liên hệ</a>
          </li>
          <li>
            <a class="lang" href="{{ $langUrl }}"><i class="fal fa-language"></i> English</a>
          </li>
        </ul>
      </div>
      <div class="col-12 col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
        <p>Chúng tôi trên mạng xã hội</p>
        <a class="w-100 mr-2 display-4" target="_blank" href="https://www.facebook.com/CoVuaPage/"><i class="fab fa-facebook-square rounded"></i></a>
        <a class="w-100 mr-2 display-4" target="_blank" href="https://www.linkedin.com/company/chessroom/"><i class="fab fa-linkedin rounded"></i></a>
      </div>
      <div class="col-12 col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">
        <p>Đã xác thực HTML5</p>
        <a title="Valid HTML 5" class="w-100 mr-2 display-4" target="_blank" href="https://validator.w3.org/check?uri=referer">
          <i class="fab fa-html5"></i>
        </a>
      </div>
    </div>
  </div>
</footer>
<div class="modal fade" id="AdBlockModal" tabindex="-1" role="dialog" aria-label="AdBlock" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title">Phát hiện AdBlock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Đương nhiên, phần mềm chặn quảng cáo thực hiện công việc tuyệt vời trong việc chặn quảng cáo, nhưng nó cũng chặn một số tính năng hữu ích và quan trọng của trang web chúng tôi. Để có trải nghiệm trang web tốt nhất có thể, vui lòng dành chút thời gian để tắt AdBlocker của bạn.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="AdSenseModal" tabindex="-1" role="dialog" aria-label="AdSense" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow-lg">
      <div class="modal-header">
        <h5 class="modal-title">Quảng cáo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <!-- COVUA_300x300 -->
        <ins class="adsbygoogle"
            style="display:inline-block;width:300px;height:300px"
            data-ad-client="ca-pub-3585118770961536"
            data-ad-slot="4778431880"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>
<script>
$('.menu-toggle').on('click', function(){
  if ($(this).hasClass('open')) {
    $(this).removeClass('open').removeClass('close').addClass('close');
  } else if ($(this).hasClass('close')) {
    $(this).removeClass('close').removeClass('open').addClass('open');
  }
});
// Function called if AdBlock is not detected
function adBlockNotDetected() {
//	alert('AdBlock is not enabled');
}
// Function called if AdBlock is detected
function adBlockDetected() {
	$('#AdBlockModal').modal();
}
$('#AdSenseModal').on('hide.bs.modal', function(e) {
  window.location.href = $('#create-room').attr('data-url');
})
justDetectAdblock.detectAnyAdblocker().then(function(detected) {
  if(detected){
    adBlockDetected();
  }
});
</script>
<a href="#0" class="cd-top js-cd-top rounded" style="background-image: url({{ URL::to('/') }}/img/cd-top-arrow.svg);">Top</a>
<script src="{{ URL::to('/') }}/js/to-top.js"></script>