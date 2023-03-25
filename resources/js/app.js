import './bootstrap';

import jQuery from 'jquery';
window.$ = jQuery;
window.$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
import sweetAlert2 from 'sweetalert2';
window.Swal = sweetAlert2;