/**
 * 値が存在するかどうかをチェックする
 *
 * @param {unknown} value 存在チェックを行う値
 * @returns {boolean} 値が存在しているかどうか
 */
export function isset(value: unknown): boolean {
    return !isUndefined(value) && !isNull(value);
}

/**
 * 値が undefined かどうかをチェックする
 *
 * @param {unknown} value undefined かどうかをチェックする値
 * @returns {boolean} 値が undefined かどうか
 */
export function isUndefined(value: unknown): boolean {
    return typeof value === "undefined";
}

/**
 * 値が null かどうかをチェックする
 *
 * @param {unknown} value null かどうかをチェックする値
 * @returns {boolean} 値が null かどうか
 */
export function isNull(value: unknown): boolean {
    return value === null;
}
