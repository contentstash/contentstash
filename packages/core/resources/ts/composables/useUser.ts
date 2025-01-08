export default function () {
  return {
    getFallbackAvatar: ({ user }: { user: User }) => {
      const upperCaseLetters = user.name.match(/[A-Z]/g) || [];
      return upperCaseLetters.slice(0, 3).join("");
    },
  };
}
