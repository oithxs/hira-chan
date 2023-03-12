/** テキストを切り抜く際に指定できるオプションの型 */
type cutOption = {
    start?: number;
    end?: number;
    endStr?: string;
    byte?: boolean;
};

/**
 * 指定された条件で引数の文字列を切り抜く
 *
 * @param {string} text - 原文
 * @param {cutOption} option - 省略可能
 *     - start: 文字列を切り抜くはじめの位置．初期値は 0
 *     - end: 文字列を切り抜く終わりの位置．初期値は 30
 *     - endStr: 文字列を切り抜いた場合に最後につける文字列．初期値は "..."
 *     - byte: 文字長をバイト数でカウントするか否か．初期値は true
 * @return {string} 切り抜いた文字列
 */
export const cutText = (text: string, option?: cutOption) => {
    const start = option?.start ?? 0;
    const end = option?.end ?? 30;
    const endStr = option?.endStr ?? "...";
    const byte = option?.byte ?? true;
    let byteSum = 0;
    let charNum = 0;

    if (byte) {
        text.split("").some((char) => {
            char.charCodeAt(0) > 255 ? (byteSum += 3) : byteSum++;
            charNum++;
            return byteSum >= end;
        });
    } else {
        charNum = end;
    }

    return text.length > charNum
        ? text.substring(start, charNum) + endStr
        : text;
};
