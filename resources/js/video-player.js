import videojs from "video.js";
import "video.js/dist/video-js.css";

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".video-js").forEach((el) => {
        if (!el.player) {
            videojs(el, {
                controls: true,
                autoplay: false,
                preload: "auto",
                fluid: true,
                playbackRates: [0.5, 1, 1.25, 1.5, 2],
                language: "es",
            });
        }
    });
});
