import * as React from "react";
import {
    ChannelEntity,
    EventEntity,
    RoutesEntity,
    UserEntity,
} from "../types/index";

/** アプリ全体のプロバイダに渡す引数の型 */
type AppProviderProps = {
    children: React.ReactNode;
};

/** ルート（各種ページのリンク）を保存したコンテキスト */
export const RoutesContext: React.Context<{}> = React.createContext({});

/** ログインしているユーザの情報を保存したコンテキスト */
export const UserContext: React.Context<{}> = React.createContext({});

/** Laravel からブロードキャストされるイベント名を保存したコンテキスト */
export const EventContext: React.Context<{}> = React.createContext({});

/** Laravel からイベントを受け取るために接続するチャンネル名を保存したコンテキスト */
export const ChannelContext: React.Context<{}> = React.createContext({});

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

    const routes: RoutesEntity = {
        dashboard: element?.dataset.dashboardurl ?? "",
        myPage: element?.dataset.mypageurl ?? "",
        threadHistory: element?.dataset.threadhistoryurl ?? "",
        profileShow: element?.dataset.profileshowurl ?? "",
        login: element?.dataset.loginurl ?? "",
        logout: element?.dataset.logouturl ?? "",
        register: element?.dataset.registerurl ?? "",
        hub: {
            index: element?.dataset.hubindexurl ?? "",
            store: element?.dataset.hubstoreurl ?? "",
        },
        threadPrimaryCategory: {
            index: element?.dataset.threadprimarycategoryindexurl ?? "",
        },
        threadSecondaryCategory: {
            index: element?.dataset.threadsecondarycategoryindexurl ?? "",
        },
        like: {
            store: element?.dataset.likestoreurl ?? "",
            destroy: element?.dataset.likedestroyurl ?? "",
        },
        post: {
            index: element?.dataset.postindexurl ?? "",
            store: element?.dataset.poststoreurl ?? "",
        },
    };

    const user: UserEntity = {
        name: element?.dataset.username ?? "",
    };

    const events: EventEntity = {
        threadBrowsing: {
            addLikeOnPost:
                element?.dataset.threadbrowsingaddlikeonpostevent ?? "",
            deleteLikeOnPost:
                element?.dataset.threadbrowsingdeletelikeonpostevent ?? "",
            postStored: element?.dataset.threadbrowsingpoststoredevent ?? "",
        },
    };

    const channels: ChannelEntity = {
        threadBrowsing: element?.dataset.threadbrowsingchannel ?? "",
    };

    return (
        <RoutesContext.Provider value={routes}>
            <UserContext.Provider value={user}>
                <EventContext.Provider value={events}>
                    <ChannelContext.Provider value={channels}>
                        {children}
                    </ChannelContext.Provider>
                </EventContext.Provider>
            </UserContext.Provider>
        </RoutesContext.Provider>
    );
};
