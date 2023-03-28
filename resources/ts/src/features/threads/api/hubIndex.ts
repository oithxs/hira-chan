import { useEffect } from "react";
import { axios } from "../../../lib/axios";
import { threadEntity } from "../types";

/**
 * state・スレッド一覧を取得するAPIを利用し，呼び出し元にスレッド一覧を渡す
 *
 * @param {string} hubUrl - スレッド一覧を取得するAPIのURL
 * @param {CallableFunction} setThreads - stateでスレッド一覧を保存するための関数
 */
export const hubIndex = (hubUrl: string, setThreads: CallableFunction) => {
    useEffect(() => {
        axios
            .get(hubUrl)
            .then((response: any) => {
                return response.data;
            })
            .then((data: any) => {
                return data.data;
            })
            .then((threads: threadEntity[]) => {
                setThreads(threads);
            })
            .catch((error: any) => null);
    }, []);
};
