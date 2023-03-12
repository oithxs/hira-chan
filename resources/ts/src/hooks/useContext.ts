import { useContext } from "react";
import { RoutesContext, UserContext } from "../providers/app";

/**
 * アプリで共通して使用可能なルートを返却する
 *
 * @return {{ [key: string]: string  }}
 */
export const routesContext = (): { [key: string]: string } =>
    useContext(RoutesContext);

/**
 * ログインしていれば，ログインしているユーザの情報を返却する
 *
 * @return {{ [key: string]: string }}
 */
export const userContext = (): { [key: string]: string } =>
    useContext(UserContext);
