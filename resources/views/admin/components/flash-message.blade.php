<script>
  const NotyInstance = function() {
    const _componentNoty = function(text, type) {
      // Override Noty defaults
      Noty.overrideDefaults({
        theme: 'limitless',
        layout: 'topRight',
        type: 'alert',
        timeout: 2500,
      });

      new Noty({
        text: text,
        type: type,
      }).show();
    };

    return {
      init: function() {
          @if(session('success'))
          _componentNoty('{{ session('success') }}', 'success');
          @elseif(session('error'))
          _componentNoty('{{ session('error') }}', 'error');
          @endif
      },
    };
  }();

  // Initialize module
  // ------------------------------

  document.addEventListener('DOMContentLoaded', function() {
    NotyInstance.init();
  });

</script>
