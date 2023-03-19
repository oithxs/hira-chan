import { useEffect } from "react";
import { axios } from "../../../lib/axios";

/**
 * state・大枠カテゴリ一覧を取得するAPIを利用し，呼び出し元に大枠カテゴリ一覧を渡す
 *
 * @param {string} threadPrimaryCategoryUrl - 大枠カテゴリ一覧を取得するAPIのURL
 * @param {CallableFunction} setThreadPrimaryCategorys - stateで大枠カテゴリ一覧を保存するための関数
 */
export const threadPrimaryCategoryIndex = (
    threadPrimaryCategoryUrl: string,
    setThreadPrimaryCategorys: CallableFunction
) => {
    useEffect(() => {
        axios
            .get(threadPrimaryCategoryUrl)
            .then((response: any) => {
                return response.data;
            })
            .then((data: object) => {
                setThreadPrimaryCategorys(data);
            })
            .catch((error: any) => null);
    }, []);
};
