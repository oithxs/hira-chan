import * as React from "react";
import { RoutesType, UserType } from "../types/index";

type AppProviderProps = {
    children: React.ReactNode;
};

export const RoutesContext: React.Context<{}> = React.createContext({});
export const UserContext: React.Context<{}> = React.createContext({});

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
