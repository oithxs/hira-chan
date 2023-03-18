import { KeyboardEvent, useEffect, useState } from "react";
import { Modal } from "../../../components/Modal";
import {
    threadPrimaryCategoryEntity,
    threadSecondaryCategoryEntity,
} from "../types";
import { filterType } from "./Layout";

/** スレッド検索を行うためのモーダルのフォームの引数 */
type BodyProps = {
    setFilter: CallableFunction;
    onClick: CallableFunction;
    threadPrimaryCategorys: threadPrimaryCategoryEntity[];
    threadSecondaryCategorys: threadSecondaryCategoryEntity[];
};

/**
 * スレッド検索を行うためのモーダルのフォーム
 *
 * @param {CallableFunction} setFilter - 検索条件を保存するstate
 * @param {CallableFunction} onClick - テキストエリアでEnterキーが押された際に実行
 * @param {threadPrimaryCategoryEntity[]} threadPrimaryCategorys - 大枠カテゴリ一覧
 * @param {threadSecondaryCategoryEntity[]} threadSecondaryCategorys - 詳細カテゴリ一覧
 * @returns {JSX.Element}
 */
const Body = ({
    setFilter,
    onClick,
    threadPrimaryCategorys,
    threadSecondaryCategorys,
}: BodyProps) => {
    const [secondaryCategorys, setSecondaryCategorys] = useState<
        threadSecondaryCategoryEntity[]
    >([]);

    /**
     * スレッド名が入力されるたびに実行．検索条件を保存する
     * @param text 入力されたテキスト
     */
    const handleTitleChange = (text: string) => {
        setFilter((state: filterType) => ({
            ...state,
            title: text,
        }));
    };

    /**
     * テキストエリア内でキーボードが押されるたびに実行．
     * Enterキーが押された際に「検索」ボタンを押した時と同じ動作をする
     * @param {KeyboardEvent<HTMLInputElement>} e - テキストエリア内でキーボードが押されるイベント
     */
    const handleTitleKeyDown = (e: KeyboardEvent<HTMLInputElement>) => {
        e.nativeEvent.isComposing || e.key !== "Enter" ? null : onClick();
    };

    /**
     * 大枠カテゴリが選択されるたびに実行．検索条件を保存する．
     * 選択できる詳細カテゴリを制限
     * @param primaryKey 大枠カテゴリの主キー
     */
    const handlePrimaryCategorysChange = (primaryKey: string) => {
        setFilter((state: filterType) => ({
            ...state,
            primaryCategory: threadPrimaryCategorys[Number(primaryKey) - 1],
            secondaryCategory: undefined,
        }));

        let s: threadSecondaryCategoryEntity[] = [];
        for (let i = 0; i < Number(threadSecondaryCategorys.length); i++) {
            if (
                threadSecondaryCategorys[i]["thread_primary_category_id"] ===
                Number(primaryKey)
            ) {
                s = s.concat(threadSecondaryCategorys[i]);
            }
        }
        setSecondaryCategorys(s);
    };

    /**
     * 詳細カテゴリが選択されるたびに実行．検索条件を保存する．
     * @param secondaryKey 詳細カテゴリの主キー
     */
    const handleSecondaryCategorysChange = (secondaryKey: string) =>
        setFilter((state: filterType) => ({
            ...state,
            secondaryCategory:
                threadSecondaryCategorys[Number(secondaryKey) - 1],
        }));

    return (
        <div className="modal-body">
            <div className="row">
                <label htmlFor="threadName" className="form-label">
                    スレッド名
                </label>
                <input
                    type="text"
                    id="threadName"
                    onKeyDown={(e) => handleTitleKeyDown(e)}
                    onChange={(e) => handleTitleChange(e.target.value)}
                    className="form-control"
                />
                <label htmlFor="threadCategory" className="form-label">
                    カテゴリ
                </label>
            </div>
            <div className="row">
                <div className="col-auto">
                    <select
                        className="form-select"
                        id="threadCategory"
                        onChange={(e) =>
                            handlePrimaryCategorysChange(e.target.value)
                        }
                    >
                        <option value={"全て"}>全て</option>
                        {threadPrimaryCategorys.map((o) => (
                            <option key={o["id"]} value={o["id"]}>
                                {o["name"]}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="col-auto">
                    <select
                        className="form-select"
                        onChange={(e) =>
                            handleSecondaryCategorysChange(e.target.value)
                        }
                    >
                        <option value={"未選択"}>未選択</option>
                        {secondaryCategorys.map((o) => (
                            <option key={o["id"]} value={o["id"]}>
                                {o["name"]}
                            </option>
                        ))}
                    </select>
                </div>
            </div>
        </div>
    );
};

/** スレッド検索モーダルで表示するフッターの引数 */
type FooterProps = {
    message: string;
    onClick: CallableFunction;
};

/**
 * スレッド検索モーダルで表示するフッター
 *
 * @param {string} message - 条件未入力で検索実行した際に表示するエラーメッセージ
 * @param {CallableFunction} onClick - 「検索」ボタンクリックで実行
 * @returns {JSX.Element}
 */
const Footer = ({ message, onClick }: FooterProps) => {
    return (
        <div className="modal-footer">
            <div className="text-danger">{message}</div>
            <button
                type="button"
                onClick={() => onClick()}
                onSubmit={() => onClick()}
                className="btn btn-primary bg-primary"
            >
                検索
            </button>
        </div>
    );
};

/** スレッド検索を行うためのモーダルを表示する関数の引数 */
type SearchThreadModalProps = {
    id: string;
    message: string;
    setFilter: CallableFunction;
    onClick: CallableFunction;
    threadPrimaryCategorys: threadPrimaryCategoryEntity[];
    threadSecondaryCategorys: threadSecondaryCategoryEntity[];
};

/**
 * スレッド検索を行うためのモーダルを表示する
 *
 * @param {string} id - モーダルのID
 * @param {string} message - スレッド検索時のメッセージ（主にエラーメッセージ）
 * @param {CallableFunction} setFilter - スレッドの検索条件を保存するstate
 * @param {CallableFunction} onClick - スレッド検索ボタンの動作
 * @param {threadPrimaryCategoryEntity[]} threadPrimaryCategorys - 大枠カテゴリ一覧
 * @param {threadSecondaryCategoryEntity[]} threadSecondaryCategorys - 詳細カテゴリ一覧
 * @returns {JSX.Element}
 */
export const SearchThreadModal = ({
    id,
    message,
    setFilter,
    onClick,
    threadPrimaryCategorys,
    threadSecondaryCategorys,
}: SearchThreadModalProps) => (
    <Modal id={id}>
        <div className="modal-header bg-warning bg-opacity-25">
            スレッド検索
        </div>
        <Body
            setFilter={setFilter}
            onClick={onClick}
            threadPrimaryCategorys={threadPrimaryCategorys}
            threadSecondaryCategorys={threadSecondaryCategorys}
        />
        <Footer message={message} onClick={onClick} />
    </Modal>
);
