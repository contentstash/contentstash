export default function () {
  const PHP_TYPE: Record<string, ResourceModelAttributePhpType> = {
    string: "string",
    int: "int",
    CarbonCarbonInterface: "\\Carbon\\CarbonInterface",
    mixed: "mixed",
  };
  const TYPE: Record<string, ResourceModelAttributeType> = {
    bigint: "bigint",
    text: "text",
    json: "json",
    unknown: "unknown",
  };

  return {
    PHP_TYPE,
    TYPE,
  };
}
