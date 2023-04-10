import { useEffect } from "react";
import { axios } from "../../../lib/axios";
import { routesContext } from "../../../hooks/useContext";

/**
 * state・詳細カテゴリ一覧を取得するAPIを利用し，呼び出し元に詳細カテゴリ一覧を渡す
 *
 * @param {CallableFunction} setThreadSecondaryCategorys - stateで詳細カテゴリ一覧を保存するための関数
 */
export const threadSecondaryCategoryIndex = (
    setThreadSecondaryCategorys: CallableFunction
) => {
    const routes = routesContext();

    useEffect(() => {
        axios
            .get(routes.threadSecondaryCategory.index)
            .then((response: any) => {
                return response.data;
            })
            .then((data: object) => {
                setThreadSecondaryCategorys(data);
            })
            .catch((error: any) => null);
    }, []);
};
