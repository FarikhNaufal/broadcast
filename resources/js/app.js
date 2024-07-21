import './bootstrap';
import './echo';
import './editor'
import './select';

import markdownit from 'markdown-it'
window.markdownit = markdownit;

window.Echo.channel('status-channel').listen('SetClientStatus', function (response) {
    Livewire.dispatch('client-changed')
});
export default markdownit;

