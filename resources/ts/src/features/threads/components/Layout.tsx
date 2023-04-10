import { useEffect, useState } from "react";
import { routesContext } from "../../../hooks/useContext";
import { formatDate } from "../../../utils/format";
import { hubIndex } from "../api/hubIndex";
import { threadPrimaryCategoryIndex } from "../api/threadPrimaryCategoryIndex";
import { threadSecondaryCategoryIndex } from "../api/threadSecondaryCategoryIndex";
import {
    threadEntity,
    threadPrimaryCategoryEntity,
    threadSecondaryCategoryEntity,
} from "../types/index";
import { SearchThreadModal } from "./SearchThreadModal";

/** テーブルのヘッダを表示する関数の引数 */
type TheadProps = {
    onChange: CallableFunction;
    setSearchThreadModalIsOpen: CallableFunction;
};

/**
 * スレッドテーブルのヘッダを表示する
 *
 * @param {CallableFunction} onChange - 表示するスレッド行数を変更する
 * @param {CallableFunction} setSearchThreadModalIsOpen - モーダル表示のフラグ
 * @returns {JSX.Element}
 */
const Thead = ({ onChange, setSearchThreadModalIsOpen }: TheadProps) => {
    return (
        <thead>
            <tr>
                <th>
                    <div className="d-flex align-items-center">
                        <div className="align-middle fs-4">スレッド</div>
                        <button
                            onClick={() => setSearchThreadModalIsOpen(true)}
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="currentColor"
                                className="bi bi-search"
                                viewBox="0 0 16 16"
                            >
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                    <div className="d-flex align-items-center">
                        <div className="d-flex align-items-center">
                            <label htmlFor="selectRow">{"行数："}</label>
                            <select
                                id="selectRow"
                                className="form-select col"
                                onChange={(e) => onChange(e.target.value)}
                            >
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                    </div>
                </th>
            </tr>
        </thead>
    );
};

/** スレッドテーブルのbodyを表示する関数の引数 */
type TbodyType = {
    threads: threadEntity[];
    threadSecondaryCategorys: threadSecondaryCategoryEntity[];
    threadNum: threadNumType;
    dashboardUrl: string;
};

/**
 * スレッドテーブルのbodyを表示する
 *
 * @param {threadEntity[]} threads - スレッド一覧
 * @param {threadSecondaryCategoryEntity[]} threadSecondaryCategorys - 詳細カテゴリ一覧
 * @param {threadNumType} threadNum - 1ページに表示するスレッド数や，表示しているページなど
 * @param {string} dashboardUrl - ダッシュボードのURL
 * @returns {JSX.Element}
 */
const Tbody = ({
    threadNum,
    threadSecondaryCategorys,
    threads,
    dashboardUrl,
}: TbodyType) => {
    const someThreads = threads.slice(
        threadNum.row * (threadNum.page - 1),
        threadNum.row * threadNum.page
    );

    const tbody = someThreads.map((o: threadEntity, i: number) => {
        const threadSecondaryCategory: threadSecondaryCategoryEntity =
            threadSecondaryCategorys[o["secondaryCategoryId"] - 1] ?? {};
        const threadPrimaryCategory: threadPrimaryCategoryEntity =
            threadSecondaryCategory["thread_primary_category"] ?? {};
        const url: string = dashboardUrl + "?thread_id=" + o["id"];

        return (
            <tr key={i}>
                <td className="a-block">
                    <a href={url}>
                        <p>
                            <small>
                                {threadPrimaryCategory["name"]}
                                {"："}
                                {threadSecondaryCategory["name"]}
                                {" / "}
                                {"作成："}
                                {formatDate(o["createdAt"])}
                            </small>
                        </p>
                        <p>{o["name"]}</p>
                    </a>
                </td>
            </tr>
        );
    });

    return <tbody>{tbody}</tbody>;
};

/** スレッドのページを表示する関数の引数 */
type SelectPageProps = {
    threadNum: threadNumType;
    onClick: CallableFunction;
};

/**
 * スレッドのページを表示する（現在のページ・表示できるページ）
 *
 * @param {threadNumType} threadNum - 1ページに表示するスレッド数や，表示しているページなど
 * @param {CallableFunction} onClick - 表示するページ数変更のボタンクリックイベント
 * @returns
 */
const SelectPage = ({ threadNum, onClick }: SelectPageProps) => {
    const pagesLength = threadNum.pages.length;

    /**
     * 表示する最小ページを取得する
     * @returns {number}
     */
    const min = () => {
        if (1 <= threadNum.page - 5) {
            if (pagesLength - 10 < threadNum.page - 5) {
                return pagesLength - 10;
            }
            return threadNum.page - 5;
        } else {
            return 0;
        }
    };

    /**
     * 表示する最大ページを取得する
     * @returns {number}
     */
    const max = () => {
        if (threadNum.page + 5 < pagesLength) {
            if (threadNum.page + 5 < 10 && 10 < pagesLength) {
                return 10;
            }
            return threadNum.page + 5;
        } else {
            return pagesLength;
        }
    };

    const somePages = threadNum.pages.slice(min(), max());

    return (
        <div className="d-flex justify-content-center">
            <a
                href="#"
                className="btn"
                onClick={() => onClick(threadNum.page - 1)}
            >
                前へ
            </a>
            {somePages.map((o) => {
                const className: string =
                    o === threadNum.page ? "btn btn-info" : "btn";
                return (
                    <a
                        href="#"
                        key={o}
                        className={className}
                        onClick={() => onClick(o)}
                    >
                        {o}
                    </a>
                );
            })}
            <a
                href="#"
                className="btn"
                onClick={() => onClick(threadNum.page + 1)}
            >
                次へ
            </a>
        </div>
    );
};

/** スレッド検索条件の型 */
export type filterType = {
    title?: string;
    primaryCategory?: threadPrimaryCategoryEntity;
    secondaryCategory?: threadSecondaryCategoryEntity;
};

/** 1ページに表示するスレッド数や，表示しているページなどの型 */
export type threadNumType = {
    row: number;
    page: number;
    pages: number[];
};

/**
 * スレッド一覧などを表示する
 *
 * @returns {JSX.Element}
 */
export const Layout = () => {
    const routes = routesContext();
    const [filter, setFilter] = useState<filterType>({});
    const [threadNum, setThreadNum] = useState<threadNumType>({
        row: 10,
        page: 1,
        pages: [],
    });
    const [threads, setThreads] = useState<threadEntity[]>([]);
    const [processedThreads, setProcessedThreads] = useState<threadEntity[]>(
        []
    );
    const [threadPrimaryCategorys, setThreadPrimaryCategorys] = useState<
        threadPrimaryCategoryEntity[]
    >([]);
    const [threadSecondaryCategorys, setThreadSecondaryCategorys] = useState<
        threadSecondaryCategoryEntity[]
    >([]);
    const [searchThreadModalIsOpen, setSearchThreadModalIsOpen] =
        useState<boolean>(false);

    hubIndex(setThreads);
    threadPrimaryCategoryIndex(setThreadPrimaryCategorys);
    threadSecondaryCategoryIndex(setThreadSecondaryCategorys);
    useEffect(() => setProcessedThreads(threads), [threads]);
    useEffect(() => {
        setThreadNum((state: threadNumType) => ({
            ...state,
            pages: Array.from(
                Array(Math.ceil(processedThreads.length / threadNum.row)),
                (_, i) => i + 1
            ),
        }));
    }, [processedThreads]);

    /** スレッドの検索実行 */
    const handleSearchThreadClick = () => {
        setProcessedThreads(
            threads.filter((o) => {
                let response: boolean = true;

                if (filter.title && !o.name.match(filter.title)) {
                    response = false;
                }
                if (
                    filter.primaryCategory &&
                    o.primaryCategoryId !== filter.primaryCategory.id
                ) {
                    response = false;
                }
                if (
                    filter.secondaryCategory &&
                    o.secondaryCategoryId !== filter.secondaryCategory.id
                ) {
                    response = false;
                }

                return response;
            })
        );
        setThreadNum((state: threadNumType) => ({
            ...state,
            pages: Array.from(
                Array(Math.ceil(processedThreads.length / threadNum.row)),
                (_, i) => i + 1
            ),
        }));
        setFilter({});
        setSearchThreadModalIsOpen(false);
    };

    /**
     * 行数が選択されるたびに実行．行数を保存する
     * @param {string} v - 選択された行数
     */
    const handleRowChange = (v: string) =>
        setThreadNum({
            row: Number(v),
            page: 1,
            pages: Array.from(
                Array(Math.ceil(threads.length / Number(v))),
                (_, i) => i + 1
            ),
        });

    /**
     * スレッド一覧のページ移動のためにデータを保存する
     * @param {number} selectedPage 選択されたページ
     */
    const handleSelectPageClick = (selectedPage: number) => {
        threadNum.pages.some((e) => e === selectedPage)
            ? setThreadNum((state: threadNumType) => ({
                  ...state,
                  page: selectedPage,
              }))
            : null;
    };

    return (
        <div>
            <table className="table table-hover">
                <Thead
                    onChange={handleRowChange}
                    setSearchThreadModalIsOpen={setSearchThreadModalIsOpen}
                />
                <Tbody
                    threads={processedThreads}
                    threadSecondaryCategorys={threadSecondaryCategorys}
                    threadNum={threadNum}
                    dashboardUrl={routes.dashboard}
                />
            </table>
            <SelectPage threadNum={threadNum} onClick={handleSelectPageClick} />
            <SearchThreadModal
                isOpen={searchThreadModalIsOpen}
                setIsOpen={setSearchThreadModalIsOpen}
                setFilter={setFilter}
                onClick={handleSearchThreadClick}
                threadPrimaryCategorys={threadPrimaryCategorys}
                threadSecondaryCategorys={threadSecondaryCategorys}
            />
        </div>
    );
};
