const Axios = require("axios").default;
const csrfToken: string =
    document.head
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content") ?? "";

export const axios = Axios.create({
    headers: { "X-CSRF-TOKEN": csrfToken },
});
