import { useContext } from "react";
import { RoutesContext, UserContext } from "../providers/app";
import { RoutesEntity, UserEntity } from "../types";

/**
 * アプリで共通して使用可能なルートを返却する
 *
 * @return { RoutesEntity }
 */
export const routesContext = () => useContext(RoutesContext) as RoutesEntity;

/**
 * ログインしていれば，ログインしているユーザの情報を返却する
 *
 * @return { UserEntity }
 */
export const userContext = () => useContext(UserContext) as UserEntity;
