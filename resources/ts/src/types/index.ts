/** アプリ共通で使用可能なルートの型 */
export type RoutesType = {
    dashboard: string;
    myPage: string;
    threadHistory: string;
    profileShow: string;
    login: string;
    logout: string;
    register: string;
    hub: string;
    threadPrimaryCategory: string;
    threadSecondaryCategory: string;
};

/** ログインしてるユーザ情報の型 */
export type UserType = {
    name: string;
};
