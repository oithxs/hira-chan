import { useContext } from "react";
import {
    ChannelContext,
    EventContext,
    RoutesContext,
    UserContext,
} from "../providers/app";
import { ChannelEntity, EventEntity, RoutesEntity, UserEntity } from "../types";

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

/**
 * /** Laravel からブロードキャストされるイベント名を返却する
 *
 * @returns { EventEntity }
 */
export const eventsContext = () => useContext(EventContext) as EventEntity;

/**
 * /** Laravel からイベントを受け取るために接続するチャンネル名を返却する
 *
 * @returns { ChannelEntity }
 */
export const channelsContext = () =>
    useContext(ChannelContext) as ChannelEntity;
