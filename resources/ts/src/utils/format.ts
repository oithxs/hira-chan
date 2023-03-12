type cutOption = {
    start?: number;
    end?: number;
    endStr?: string;
    byte?: boolean;
};

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
