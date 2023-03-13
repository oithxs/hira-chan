import * as React from "react";
import { RoutesType, UserType } from "../types/index";

/** アプリ全体のプロバイダに渡す引数の型 */
type AppProviderProps = {
    children: React.ReactNode;
};

/** ルート（各種ページのリンク）を保存したコンテキスト */
export const RoutesContext: React.Context<{}> = React.createContext({});

/** ログインしているユーザの情報を保存したコンテキスト */
export const UserContext: React.Context<{}> = React.createContext({});

/**
 * アプリ共通で使用可能な値を設定する
 *
 * @param {React.ReactNode} - 表示するレイアウト
 * @return {JSX.Element}
 */
export const AppProvider: CallableFunction = ({
    children,
}: AppProviderProps) => {
    const element = document.getElementById("main");

    const routes: RoutesType = {
        dashboard: element?.dataset.dashboardurl ?? "",
        myPage: element?.dataset.mypageurl ?? "",
        threadHistory: element?.dataset.threadhistoryurl ?? "",
        profileShow: element?.dataset.profileshowurl ?? "",
        login: element?.dataset.loginurl ?? "",
        logout: element?.dataset.logouturl ?? "",
        register: element?.dataset.registerurl ?? "",
        "hub.index": element?.dataset.hubindexurl ?? "",
    };

    const user: UserType = {
        name: element?.dataset.username ?? "",
    };

    return (
        <RoutesContext.Provider value={routes}>
            <UserContext.Provider value={user}>{children}</UserContext.Provider>
        </RoutesContext.Provider>
    );
};
