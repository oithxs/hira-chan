import Echo from "laravel-echo";

/** サーバからのイベントを受け取ることが可能 */
export const laravelEcho = new Echo({
    broadcaster: "socket.io",
    host: window.location.hostname + ":6001",
});
