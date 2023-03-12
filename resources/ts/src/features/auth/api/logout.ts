import { axios } from "../../../lib/axios";

/**
 * 呼び出すことでログアウトを行う
 *
 * @param {string} logoutUrl - ログアウトを行うためのURL
 */
export const logout = (logoutUrl: string) =>
    axios
        .post(logoutUrl)
        .then(() => window.location.reload())
        .catch((error: any) => null);
