'use strict';
// Native HTML5 audio — Bootstrap styles handle the rest.
// Auto-play is intentionally disabled for accessibility/UX.
document.addEventListener('DOMContentLoaded', () => {
    const player = document.getElementById('audioPlayer');
    if (!player) return;
    player.addEventListener('error', () => {
        player.closest('.audio-player-wrapper')?.classList.add('d-none');
    });
});
