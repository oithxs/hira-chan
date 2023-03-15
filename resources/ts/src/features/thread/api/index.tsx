import { useEffect } from "react";
import { axios } from "../../../lib/axios";

/**
 * state・スレッド一覧を取得するAPIを利用し，呼び出し元にスレッド一覧を渡す
 *
 * @param {string} hubIndexUrl - スレッド一覧を取得するAPIのURL
 * @param {CallableFunction} setThreads - stateでスレッド一覧を保存するための関数
 */
export const index = (hubIndexUrl: string, setThreads: CallableFunction) => {
    useEffect(() => {
        axios
            .get(hubIndexUrl)
            .then((response: any) => {
                return response.data;
            })
            .then((data: object) => {
                setThreads(data);
            })
            .catch((error: any) => null);
    }, []);
};
