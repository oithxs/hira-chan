import { axios } from "../../../lib/axios";

export const logout = (logoutUrl: string) =>
    axios
        .post(logoutUrl)
        .then(() => window.location.reload())
        .catch((error: any) => null);
