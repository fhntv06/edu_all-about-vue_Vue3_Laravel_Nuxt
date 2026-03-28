import { fetchBroadcastingAuth } from "@/api";

export default {
  broadcaster: "reverb",
  key: import.meta.env.VITE_REVERB_APP_KEY || 'broadcasting-reverb-key-from-backend',
  wsHost:import.meta.env.VITE_REVERB_HOST || 'backend-host',
  wsPort:import.meta.env.VITE_REVERB_PORT ?? 80,
  wssPort:import.meta.env.VITE_REVERB_PORT ?? 443,
  forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "https") === "https",
  namespace: 'App.Events.Post',
  authorizer: (channel, options) => {
    return {
      authorize: async (socketId, callback ) => {
        try {
          const res = await fetchBroadcastingAuth({
            body: JSON.stringify({
              socket_id: socketId,
              channel_name: channel.name,
            }),
          });

          const data = await res.json();
          callback(false, data);
        } catch (err) {
          callback(true, err);
        }
      }
    }
  }
}
