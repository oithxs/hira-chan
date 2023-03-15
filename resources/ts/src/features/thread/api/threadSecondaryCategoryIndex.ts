import { useEffect } from "react";
import { axios } from "../../../lib/axios";

/**
 * state・詳細カテゴリ一覧を取得するAPIを利用し，呼び出し元に詳細カテゴリ一覧を渡す
 *
 * @param {string} threadSecondaryCategoryUrl - 詳細カテゴリ一覧を取得するAPIのURL
 * @param {CallableFunction} setThreadSecondaryCategorys - stateで詳細カテゴリ一覧を保存するための関数
 */
export const threadSecondaryCategoryIndex = (
    threadSecondaryCategoryUrl: string,
    setThreadSecondaryCategorys: CallableFunction
) => {
    useEffect(() => {
        axios
            .get(threadSecondaryCategoryUrl)
            .then((response: any) => {
                return response.data;
            })
            .then((data: object) => {
                setThreadSecondaryCategorys(data);
            })
            .catch((error: any) => null);
    }, []);
};
