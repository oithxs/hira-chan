/** アプリ共通で使用可能なルートの型 */
export type RoutesEntity = {
    dashboard: string;
    myPage: string;
    threadHistory: string;
    profileShow: string;
    login: string;
    logout: string;
    register: string;
    hub: {
        index: string;
        store: string;
    };
    threadPrimaryCategory: {
        index: string;
    };
    threadSecondaryCategory: {
        index: string;
    };
    like: {
        store: string;
        destroy: string;
    };
    post: {
        index: string;
        store: string;
    };
};

/** ログインしてるユーザ情報の型 */
export type UserEntity = {
    name: string;
};

/** Laravel からブロードキャストされるイベント名 */
export type EventEntity = {
    threadBrowsing: {
        addLikeOnPost: string;
        deleteLikeOnPost: string;
        postStored: string;
    };
};

/** Laravel からイベントを受け取るために接続するチャンネル名 */
export type ChannelEntity = {
    threadBrowsing: string;
};
