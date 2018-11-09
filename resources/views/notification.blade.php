<script src="{{url('js/notify.js')}}"></script>

<div class='notifications top-right'>
</div>
<div class="notifications top-left"></div>
<script>

  @if(Session::has('success'))
     $('.top-right').notify({
        message: { text: "{{ Session::get('success') }}" }
      }).show();
     @php
       Session::forget('success');
     @endphp
  @endif

  @if(Session::has('deleted'))
       $('.top-left').notify({
          message: { text: "{{ Session::get('deleted') }}" }
        }).show();
       @php
         Session::forget('deleted');
       @endphp
    @endif


  @if(Session::has('info'))
      $('.top-right').notify({
        message: { text: "{{ Session::get('info') }}" },
        type:'info'
      }).show();
      @php
        Session::forget('info');
      @endphp
  @endif

  @if(Session::has('warning'))
  		$('.top-right').notify({
        message: { text: "{{ Session::get('warning') }}" },
        type:'warning'
      }).show();
      @php
        Session::forget('warning');
      @endphp
  @endif

  @if(Session::has('error'))
  		$('.top-right').notify({
        message: { text: "{{ Session::get('error') }}" },
        type:'danger'
      }).show();
      @php
        Session::forget('error');
      @endphp
  @endif

</script>