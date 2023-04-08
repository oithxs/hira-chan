import { useEffect } from "react";
import { axios } from "../../../lib/axios";
import { routesContext } from "../../../hooks/useContext";

/**
 * state・大枠カテゴリ一覧を取得するAPIを利用し，呼び出し元に大枠カテゴリ一覧を渡す
 *
 * @param {CallableFunction} setThreadPrimaryCategorys - stateで大枠カテゴリ一覧を保存するための関数
 */
export const threadPrimaryCategoryIndex = (
    setThreadPrimaryCategorys: CallableFunction
) => {
    const routes = routesContext();

    useEffect(() => {
        axios
            .get(routes.threadPrimaryCategory.index)
            .then((response: any) => {
                return response.data;
            })
            .then((data: object) => {
                setThreadPrimaryCategorys(data);
            })
            .catch((error: any) => null);
    }, []);
};
