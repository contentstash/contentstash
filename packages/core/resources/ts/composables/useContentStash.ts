import corePackageJson from "../../../package.json";

export default function () {
  return {
    getInfo: () => {
      return {
        core: {
          version: corePackageJson.version,
        },
      };
    },
  };
}
