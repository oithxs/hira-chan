const Axios = require("axios").default;

/** CSRFトークン */
const csrfToken: string =
    document.head
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content") ?? "";

/**
 * CSRFトークンをヘッダにつけた状態でリクエストが可能
 */
export const axios = Axios.create({
    headers: { "X-CSRF-TOKEN": csrfToken },
});
